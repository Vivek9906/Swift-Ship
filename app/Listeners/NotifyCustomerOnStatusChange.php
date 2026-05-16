<?php

namespace App\Listeners;

use App\Events\ShipmentStatusUpdated;
use Illuminate\Support\Facades\Log;

class NotifyCustomerOnStatusChange
{
    public function handle(ShipmentStatusUpdated $event): void
    {
        Log::info('Customer status notification queued', [
            'tracking_number' => $event->shipment->tracking_number,
            'customer_email' => $event->shipment->customer?->email,
            'status' => $event->shipment->status,
        ]);
    }
}
