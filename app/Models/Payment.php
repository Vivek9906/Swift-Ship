<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'shipment_id',
        'transaction_id',
        'gateway',
        'amount',
        'currency',
        'status',
        'payment_method',
        'invoice_number',
        'gateway_response',
        'stripe_session_id',
        'stripe_payment_intent',
        'paid_at',
        'failed_at',
        'refund_amount',
        'refunded_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'failed_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
