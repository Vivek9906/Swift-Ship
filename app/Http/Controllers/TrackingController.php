<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Shipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function liveMap(Request $request): View
    {
        return view('tracking.live-map', [
            'carriers' => Carrier::orderBy('name')->get(),
            'statuses' => Shipment::STATUSES,
            'cities' => Shipment::CITY_COORDINATES,
        ]);
    }

    public function activeShipments(Request $request): JsonResponse
    {
        $shipments = Shipment::with(['user', 'carrier'])
            ->whereIn('status', ['in_transit', 'arrived_at_city', 'out_for_delivery', 'delayed'])
            ->filter($request->only(['status', 'carrier_id', 'city']))
            ->get()
            ->map(fn(Shipment $shipment) => [
                'id' => $shipment->id,
                'tracking_number' => $shipment->tracking_number,
                'user' => $shipment->user?->name,
                'carrier' => $shipment->carrier?->name,
                'status' => $shipment->status,
                'status_label' => $shipment->status_label,
                'eta' => $shipment->estimated_delivery?->format('M d, H:i'),
                'origin' => $shipment->sender_city,
                'destination' => $shipment->receiver_city,
                'lat' => (float) $shipment->current_lat,
                'lng' => (float) $shipment->current_lng,
            ]);

        return response()->json($shipments);
    }

    public function lookup(Request $request)
    {
        if ($request->filled('tracking_number')) {
            return redirect()->route('tracking.public.show', [
                'trackingNumber' => strtoupper(trim($request->input('tracking_number'))),
            ]);
        }
        return view('tracking.lookup');
    }

    public function redirectToShipment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tracking_number' => ['required', 'string', 'max:64'],
        ]);

        return redirect()->route('tracking.public.show', [
            'trackingNumber' => strtoupper(trim($validated['tracking_number'])),
        ]);
    }

    public function publicShow(string $trackingNumber): View
    {
        $shipment = Shipment::with(['user', 'carrier', 'trackingEvents'])
            ->where('tracking_number', strtoupper($trackingNumber))
            ->first();

        $route = null;
        if ($shipment) {
            $route = [
                'origin' => Shipment::CITY_COORDINATES[$shipment->sender_city] ?? [20.5937, 78.9629],
                'destination' => Shipment::CITY_COORDINATES[$shipment->receiver_city] ?? [20.5937, 78.9629],
                'current' => [(float) $shipment->current_lat, (float) $shipment->current_lng],
            ];
        }

        return view('tracking.public-show', [
            'shipment' => $shipment,
            'trackingNumber' => strtoupper($trackingNumber),
            'route' => $route,
        ]);
    }

    // ADD THIS: Standalone public tracking form page
    public function publicTrackForm(): View
    {
        return view('tracking.public-form');
    }

    // ADD THIS: Public tracking result via direct URL (used by home hero and new result page)
    public function publicTrack(string $tracking_number): View
    {
        $shipment = Shipment::with(['trackingEvents', 'carrier', 'user'])
            ->where('tracking_number', strtoupper($tracking_number))
            ->first();

        $route = null;
        if ($shipment) {
            $route = [
                'origin' => Shipment::CITY_COORDINATES[$shipment->sender_city] ?? [20.5937, 78.9629],
                'destination' => Shipment::CITY_COORDINATES[$shipment->receiver_city] ?? [20.5937, 78.9629],
                'current' => [(float) $shipment->current_lat, (float) $shipment->current_lng],
            ];
        }

        return view('tracking.public-result', [
            'shipment' => $shipment,
            'tracking_number' => strtoupper($tracking_number),
            'trackingNumber' => strtoupper($tracking_number),
            'route' => $route,
        ]);
    }
}
