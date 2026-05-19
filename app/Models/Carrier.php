<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'contact_email',
        'on_time_rate',
        'rating',
        'active_shipments',
        'base_rate',
        'per_kg_rate',
        'per_km_rate',
        'est_days_min',
        'est_days_max',
        'services',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rating'        => 'decimal:1',
            'base_rate'     => 'decimal:2',
            'per_kg_rate'   => 'decimal:2',
            'per_km_rate'   => 'decimal:4',
            'est_days_min'  => 'integer',
            'est_days_max'  => 'integer',
            'is_active'     => 'boolean',
        ];
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['type'] ?? null, fn (Builder $query, string $type) => $query->where('type', $type))
            ->when($filters['search'] ?? null, fn (Builder $query, string $search) => $query->where('name', 'like', "%{$search}%"));
    }
}
