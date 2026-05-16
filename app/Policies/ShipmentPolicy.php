<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;

class ShipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'viewer'], true);
    }

    public function view(User $user, Shipment $shipment): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->canManage();
    }

    public function update(User $user, Shipment $shipment): bool
    {
        return $user->canManage();
    }

    public function delete(User $user, Shipment $shipment): bool
    {
        return $user->isAdmin();
    }

    public function bulk(User $user): bool
    {
        return $user->canManage();
    }
}
