<?php

namespace App\Notifications;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ShipmentDelayed extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public Shipment $shipment)
    {
        $this->shipment->loadMissing('user');
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'shipment_id' => $this->shipment->id,
            'tracking_number' => $this->shipment->tracking_number,
            'user' => $this->shipment->user?->name,
            'message' => "Shipment {$this->shipment->tracking_number} is delayed.",
            'status' => $this->shipment->status,
            'eta' => $this->shipment->estimated_delivery?->toDateTimeString(),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
