<?php

namespace App\Jobs;

use App\Events\ShipmentStatusUpdated;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateShipmentLocation implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $shipmentId)
    {
    }

    public function handle(): void
    {
        $shipment = Shipment::find($this->shipmentId);

        if (! $shipment || in_array($shipment->status, ['delivered', 'failed'], true)) {
            return;
        }

        $origin = Shipment::CITY_COORDINATES[$shipment->sender_city] ?? [20.5937, 78.9629];
        $destination = Shipment::CITY_COORDINATES[$shipment->receiver_city] ?? [20.5937, 78.9629];
        $progress = match ($shipment->status) {
            'pending' => 0.08,
            'in_transit' => random_int(30, 72) / 100,
            'arrived_at_city' => 0.9,
            'out_for_delivery' => 0.96,
            'delayed' => random_int(45, 75) / 100,
            default => 0.5,
        };

        $lat = $origin[0] + (($destination[0] - $origin[0]) * $progress) + (random_int(-12, 12) / 1000);
        $lng = $origin[1] + (($destination[1] - $origin[1]) * $progress) + (random_int(-12, 12) / 1000);

        $shipment->update([
            'current_lat' => $lat,
            'current_lng' => $lng,
        ]);

        TrackingEvent::create([
            'shipment_id' => $shipment->id,
            'status' => $shipment->status,
            'location_name' => $shipment->status === 'out_for_delivery' ? $shipment->receiver_city : 'Corridor scan',
            'lat' => $lat,
            'lng' => $lng,
            'description' => 'Automated location ping from queue worker.',
            'occurred_at' => now(),
        ]);

        event(new ShipmentStatusUpdated($shipment->refresh()));
    }
}
