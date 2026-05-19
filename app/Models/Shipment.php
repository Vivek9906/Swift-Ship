<?php

namespace App\Models;

use App\Events\ShipmentStatusUpdated;
use App\Notifications\ShipmentDelayed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending',
        'confirmed',
        'picked_up',
        'in_transit',
        'arrived_at_city',
        'out_for_delivery',
        'delivered',
        'delayed',
        'cancelled',
        'failed',
    ];

    public const CITY_COORDINATES = [
        'Mumbai' => [19.0760, 72.8777],
        'Delhi' => [28.6139, 77.2090],
        'Bangalore' => [12.9716, 77.5946],
        'Hyderabad' => [17.3850, 78.4867],
        'Chennai' => [13.0827, 80.2707],
        'Kolkata' => [22.5726, 88.3639],
        'Pune' => [18.5204, 73.8567],
        'Ahmedabad' => [23.0225, 72.5714],
        'Jaipur' => [26.9124, 75.7873],
        'Kochi' => [9.9312, 76.2673],
        'Lucknow' => [26.8467, 80.9462],
        'Guwahati' => [26.1445, 91.7362],
    ];

    protected $fillable = [
        'tracking_number',
        'user_id',
        'carrier_id',
        'sender_name',
        'sender_phone',
        'sender_email',
        'sender_city',
        'pickup_address',
        'pickup_city',
        'pickup_state',
        'pickup_pin',
        'receiver_name',
        'recipient_phone',
        'recipient_email',
        'receiver_city',
        'receiver_address',
        'delivery_city',
        'delivery_state',
        'delivery_pin',
        'package_type',
        'weight',
        'dimensions',
        'declared_value',
        'quantity',
        'special_instructions',
        'is_dangerous',
        'service_type',
        'base_fare',
        'weight_charge',
        'distance_charge',
        'gst_amount',
        'cost',
        'status',
        'payment_status',
        'current_lat',
        'current_lng',
        'estimated_delivery',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'cost' => 'decimal:2',
            'base_fare' => 'decimal:2',
            'weight_charge' => 'decimal:2',
            'distance_charge' => 'decimal:2',
            'gst_amount' => 'decimal:2',
            'declared_value' => 'decimal:2',
            'current_lat' => 'decimal:7',
            'current_lng' => 'decimal:7',
            'estimated_delivery' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'is_dangerous' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Shipment $shipment) {
            $shipment->tracking_number ??= 'IND' . now()->format('ymd') . Str::upper(Str::random(6));
            [$lat, $lng] = self::CITY_COORDINATES[$shipment->sender_city] ?? [20.5937, 78.9629];
            $shipment->current_lat ??= $lat;
            $shipment->current_lng ??= $lng;
        });

        static::updated(function (Shipment $shipment) {
            if (!$shipment->wasChanged('status')) {
                return;
            }

            event(new ShipmentStatusUpdated($shipment));

            if ($shipment->status === 'delayed') {
                try {
                    Notification::send(
                        User::whereIn('role', ['admin', 'manager'])->get(),
                        new ShipmentDelayed($shipment)
                    );
                } catch (\Throwable) {
                    // Fail silently if notification classes not fully set up
                }
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function trackingEvents(): HasMany
    {
        return $this->hasMany(TrackingEvent::class)->orderBy('occurred_at');
    }

    // Scopes
    public function scopeForUser(Builder $query, string $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['confirmed', 'picked_up', 'in_transit', 'out_for_delivery']);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('tracking_number', 'like', "%{$search}%")
                        ->orWhere('sender_city', 'like', "%{$search}%")
                        ->orWhere('receiver_city', 'like', "%{$search}%")
                        ->orWhereHas('user', fn(Builder $query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['status'] ?? null, fn(Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['carrier_id'] ?? null, fn(Builder $query, string $carrierId) => $query->where('carrier_id', $carrierId))
            ->when($filters['city'] ?? null, function (Builder $query, string $city) {
                $query->where(fn(Builder $query) => $query->where('sender_city', $city)->orWhere('receiver_city', $city));
            })
            ->when($filters['from'] ?? null, fn(Builder $query, string $from) => $query->where('created_at', '>=', Carbon::parse($from)->startOfDay()))
            ->when($filters['to'] ?? null, fn(Builder $query, string $to) => $query->where('created_at', '<', Carbon::parse($to)->addDay()->startOfDay()));
    }

    // Helpers
    public function isCancellable(): bool
    {
        return !in_array($this->status, ['delivered', 'cancelled', 'failed'], true);
    }

    public function getStatusLabelAttribute(): string
    {
        return Str::headline($this->status ?? 'unknown');
    }
}
