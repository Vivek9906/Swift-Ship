<?php

use App\Jobs\UpdateShipmentLocation;
use App\Models\Shipment;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    Shipment::whereIn('status', ['in_transit', 'arrived_at_city', 'out_for_delivery', 'delayed'])
        ->pluck('id')
        ->each(fn ($id) => UpdateShipmentLocation::dispatch($id));
})->everyMinute();
