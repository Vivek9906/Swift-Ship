<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShipmentRequest;
use App\Models\Carrier;
use App\Models\User;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Shipment::class);

        $sort = $request->string('sort')->toString();
        $direction = $request->string('direction')->toString() === 'asc' ? 'asc' : 'desc';
        $sortable = ['tracking_number', 'sender_city', 'receiver_city', 'status', 'estimated_delivery', 'updated_at'];

        $query = Shipment::with(['user', 'carrier'])
            ->filter($request->only(['search', 'status', 'carrier_id', 'city', 'from', 'to']))
            ->when(in_array($sort, $sortable, true), fn($query) => $query->orderBy($sort, $direction));

        $shipments = ($sort ? $query : $query->latest())
            ->paginate(15)
            ->withQueryString();

        return view('shipments.index', [
            'shipments' => $shipments,
            'carriers' => Carrier::orderBy('name')->get(),
            'users' => User::customers()
                ->orderBy('name')
                ->get(),
            'statuses' => Shipment::STATUSES,
            'cities' => array_keys(Shipment::CITY_COORDINATES),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Shipment::class);

        return view('shipments.create', [
            'users' => User::customers()
                ->orderBy('name')
                ->get(),
            'carriers' => Carrier::orderBy('name')->get(),
            'statuses' => Shipment::STATUSES,
            'cities' => array_keys(Shipment::CITY_COORDINATES),
        ]);
    }

    public function store(StoreShipmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['estimated_delivery'])) {
            $data['estimated_delivery'] = $this->calculateExpectedDelivery($data);
        }
        $data['user_id'] = auth()->id();
        $shipment = Shipment::create($data);
        $this->recordTrackingEvent($shipment, 'Shipment registered in control tower.');

        return redirect()->route('shipments.show', $shipment)->with('status', 'Shipment created.');
    }

    public function show(Shipment $shipment): View
    {
        Gate::authorize('view', $shipment);

        $shipment->load(['user.shipments', 'carrier', 'trackingEvents']);
        $route = [
            'origin' => Shipment::CITY_COORDINATES[$shipment->sender_city] ?? [20.5937, 78.9629],
            'destination' => Shipment::CITY_COORDINATES[$shipment->receiver_city] ?? [20.5937, 78.9629],
            'current' => [(float) $shipment->current_lat, (float) $shipment->current_lng],
        ];

        return view('shipments.show', compact('shipment', 'route'));
    }

    public function edit(Shipment $shipment): View
    {
        Gate::authorize('update', $shipment);

        return view('shipments.edit', [
            'shipment' => $shipment,
            'users' => User::customers()
                ->orderBy('name')
                ->get(),
            'carriers' => Carrier::orderBy('name')->get(),
            'statuses' => Shipment::STATUSES,
            'cities' => array_keys(Shipment::CITY_COORDINATES),
        ]);
    }

    public function update(StoreShipmentRequest $request, Shipment $shipment): RedirectResponse
    {
        Gate::authorize('update', $shipment);

        $oldStatus = $shipment->status;
        $data = $request->validated();
        if (empty($data['estimated_delivery'])) {
            $data['estimated_delivery'] = $this->calculateExpectedDelivery($data);
        }

        $shipment->update($data + [
            'delivered_at' => $request->status === 'delivered' ? now() : $shipment->delivered_at,
        ]);

        if ($oldStatus !== $shipment->status) {
            $this->recordTrackingEvent($shipment, 'Status changed from ' . str($oldStatus)->headline() . ' to ' . $shipment->status_label . '.');
        }

        return redirect()->route('shipments.show', $shipment)->with('status', 'Shipment updated.');
    }

    public function destroy(Shipment $shipment): RedirectResponse
    {
        Gate::authorize('delete', $shipment);

        $shipment->delete();

        return redirect()->route('shipments.index')->with('status', 'Shipment deleted.');
    }

    public function bulk(Request $request): mixed
    {
        Gate::authorize('bulk', Shipment::class);

        $validated = $request->validate([
            'action' => ['required', 'in:delivered,reassign,export'],
            'shipment_ids' => ['required', 'array'],
            'shipment_ids.*' => [Rule::exists(Shipment::class, 'id')],
            'carrier_id' => ['nullable', Rule::exists(Carrier::class, 'id')],
        ]);

        $shipments = Shipment::with(['user', 'carrier'])->whereIn('id', $validated['shipment_ids'])->get();

        if ($validated['action'] === 'export') {
            return $this->exportCsv($shipments);
        }

        foreach ($shipments as $shipment) {
            if ($validated['action'] === 'delivered') {
                $shipment->update(['status' => 'delivered', 'delivered_at' => now()]);
                $this->recordTrackingEvent($shipment, 'Bulk action marked shipment delivered.');
            }

            if ($validated['action'] === 'reassign' && filled($validated['carrier_id'] ?? null)) {
                $shipment->update(['carrier_id' => $validated['carrier_id']]);
                $this->recordTrackingEvent($shipment, 'Carrier reassigned by operations manager.');
            }
        }

        return back()->with('status', 'Bulk action applied.');
    }

    private function exportCsv($shipments): mixed
    {
        return Response::streamDownload(function () use ($shipments) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tracking #', 'user', 'Origin', 'Destination', 'Status', 'Carrier', 'ETA']);
            foreach ($shipments as $shipment) {
                fputcsv($handle, [
                    $shipment->tracking_number,
                    $shipment->user?->name,
                    $shipment->sender_city,
                    $shipment->receiver_city,
                    $shipment->status_label,
                    $shipment->carrier?->name,
                    $shipment->estimated_delivery?->toDateTimeString(),
                ]);
            }
            fclose($handle);
        }, 'shipments-export.csv');
    }

    private function recordTrackingEvent(Shipment $shipment, string $description): void
    {
        $coordinates = Shipment::CITY_COORDINATES[$shipment->receiver_city] ?? [20.5937, 78.9629];

        TrackingEvent::create([
            'shipment_id' => $shipment->id,
            'status' => $shipment->status,
            'location_name' => $shipment->status === 'pending' ? $shipment->sender_city : $shipment->receiver_city,
            'lat' => $shipment->current_lat ?: $coordinates[0],
            'lng' => $shipment->current_lng ?: $coordinates[1],
            'description' => $description,
            'occurred_at' => now(),
        ]);
    }

    private function calculateExpectedDelivery(array $data): \Illuminate\Support\Carbon
    {
        $originCity = $data['sender_city'] ?? '';
        $destCity = $data['receiver_city'] ?? '';

        $coords = Shipment::CITY_COORDINATES;
        $origin = $coords[$originCity] ?? [20.5937, 78.9629];
        $dest = $coords[$destCity] ?? [20.5937, 78.9629];

        // Haversine formula
        $R = 6371;
        $dL = deg2rad($dest[0] - $origin[0]);
        $dO = deg2rad($dest[1] - $origin[1]);
        $a = sin($dL / 2) ** 2 + cos(deg2rad($origin[0])) * cos(deg2rad($dest[0])) * sin($dO / 2) ** 2;
        $distKm = $R * 2 * atan2(sqrt($a), sqrt(1 - $a));

        $speedKmPerDay = match ($data['service_type'] ?? 'standard') {
            'express' => 800,
            'same_day' => 2000,
            'economy' => 250,
            default => 400,
        };

        $estDays = max(1, ceil($distKm / $speedKmPerDay));
        return now()->addDays($estDays);
    }
}
