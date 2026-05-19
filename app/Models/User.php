<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }
    public function isCustomer(): bool
    {
        return in_array($this->role, ['customer', 'user'], true);
    }
    // Legacy alias
    public function isuser(): bool
    {
        return $this->isCustomer();
    }
    public function isAdminOrStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff', 'manager', 'viewer'], true);
    }
    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'manager'], true);
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->whereIn('role', ['customer', 'user']);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Notification helpers
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }

    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function readNotifications(): MorphMany
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    public function getUnreadNotificationsAttribute(): DatabaseNotificationCollection
    {
        return new DatabaseNotificationCollection($this->unreadNotifications()->get()->all());
    }
}
