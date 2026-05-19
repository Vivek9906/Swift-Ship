<?php

namespace App\Providers;

use App\Events\ShipmentStatusUpdated;
use App\Listeners\NotifyuserOnStatusChange;
use App\Models\Shipment;
use App\Policies\ShipmentPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::policy(Shipment::class, ShipmentPolicy::class);
        Event::listen(ShipmentStatusUpdated::class, NotifyuserOnStatusChange::class);
    }
}
