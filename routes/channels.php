<?php

use App\Models\Shipment;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn ($user, int $id) => (int) $user->id === $id);

Broadcast::channel('shipment.{shipmentId}', function ($user, int $shipmentId) {
    return Shipment::whereKey($shipmentId)->exists();
});
