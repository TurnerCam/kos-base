<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class GatekeeperStatus extends Model
{
    protected $casts = [
        'lock_in' => 'datetime',
        'last_seen' => 'datetime',
    ];

    public function gatekeeper(): HasOne
    {
        return $this->hasOne(Gatekeeper::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
