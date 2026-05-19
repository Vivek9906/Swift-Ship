<?php

namespace App\Listeners;

use App\Events\ShipmentStatusUpdated;
use Illuminate\Support\Facades\Log;

class NotifyuserOnStatusChange
{
    public function handle(ShipmentStatusUpdated $event): void
    {
        Log::info('user status notification queued', [
            'tracking_number' => $event->shipment->tracking_number,
            'user_email' => $event->shipment->user?->email,
            'status' => $event->shipment->status,
        ]);
    }
}
