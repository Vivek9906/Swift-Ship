<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserProfile extends Model
{
    protected $collection = 'user_profiles';

    protected $fillable = [
        'user_id',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
