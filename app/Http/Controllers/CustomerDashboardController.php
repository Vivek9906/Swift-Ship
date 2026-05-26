<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $justBooked = request('booked')
            ? Shipment::where('tracking_number', request('booked'))
                ->where('user_id', $user->id)->first()
            : null;

        $shipments = Shipment::where('user_id', $user->id)
            ->with(['carrier', 'payment'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Shipment::where('user_id', $user->id)->count(),
            'active' => Shipment::where('user_id', $user->id)
                ->whereIn('status', ['confirmed', 'picked_up', 'in_transit', 'out_for_delivery'])
                ->count(),
            'delivered' => Shipment::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'cancelled' => Shipment::where('user_id', $user->id)->where('status', 'cancelled')->count(),
            'pending' => Shipment::where('user_id', $user->id)
                ->whereIn('payment_status', ['pending', 'cod_pending'])->count(),
        ];

        return view('customer.dashboard', compact('shipments', 'stats', 'justBooked'));
    }

    public function shipments(): View
    {
        $user = auth()->user();

        $shipments = Shipment::where('user_id', $user->id)
            ->with(['carrier', 'payment'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.shipments', compact('shipments'));
    }

    public function shipmentDetail(string $id): View
    {
        $user = auth()->user();
        $shipment = Shipment::where('user_id', $user->id)
            ->with(['carrier', 'trackingEvents', 'payment'])
            ->findOrFail($id);

        return view('customer.shipment-detail', compact('shipment'));
    }

    public function cancelShipment(string $id, Request $request): RedirectResponse
    {
        $user = auth()->user();
        $shipment = Shipment::where('user_id', $user->id)->findOrFail($id);

        // Only cancellable statuses
        abort_unless($shipment->isCancellable(), 403, 'This shipment cannot be cancelled.');

        $reason = $request->input('reason', 'Cancelled by customer.');

        $shipment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        TrackingEvent::create([
            'shipment_id' => $shipment->id,
            'status' => 'cancelled',
            'location_name' => $shipment->sender_city ?? $shipment->pickup_city ?? '—',
            'description' => 'Shipment cancelled by customer: ' . $reason,
            'occurred_at' => now(),
        ]);

        return back()->with('success', 'Shipment cancelled successfully.');
    }

    public function profile(): View
    {
        $user = auth()->user()->load('profile');

        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($request->input('change_password')) {
            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success', 'Password updated successfully.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$user->id},_id"],
            'phone' => ['nullable', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
        ]);

        if (!empty($validated['phone']) && preg_match('/^(\+91|91)?([6-9]\d{9})$/', $validated['phone'], $matches)) {
            $validated['phone'] = '+91' . $matches[2];
        }

        $user->update($validated);
        
        if (!empty($validated['phone'])) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['phone' => $validated['phone']]
            );
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function deleteShipment(string $id): RedirectResponse
    {
        $user = auth()->user();
        $shipment = Shipment::where('user_id', $user->id)->findOrFail($id);

        // Delete associated payment and tracking events
        $shipment->payment()?->delete();
        $shipment->trackingEvents()->delete();
        $shipment->delete();

        return redirect()->route('customer.dashboard')->with('success', 'Pending shipment deleted successfully.');
    }
}
