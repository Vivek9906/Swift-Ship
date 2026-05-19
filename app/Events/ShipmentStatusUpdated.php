<?php

namespace App\Events;

use App\Models\Shipment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentStatusUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Shipment $shipment)
    {
        $this->shipment->loadMissing(['user', 'carrier']);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('shipment.' . $this->shipment->id);
    }

    public function broadcastAs(): string
    {
        return 'ShipmentStatusUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->shipment->id,
            'tracking_number' => $this->shipment->tracking_number,
            'status' => $this->shipment->status,
            'status_label' => $this->shipment->status_label,
            'lat' => (float) $this->shipment->current_lat,
            'lng' => (float) $this->shipment->current_lng,
            'user' => $this->shipment->user?->name,
            'carrier' => $this->shipment->carrier?->name,
            'eta' => $this->shipment->estimated_delivery?->toIso8601String(),
        ];
    }
}
