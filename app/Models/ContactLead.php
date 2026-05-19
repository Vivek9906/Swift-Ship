<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'business_type',
        'monthly_volume',
        'message',
        'status',
        'assigned_to',
    ];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
