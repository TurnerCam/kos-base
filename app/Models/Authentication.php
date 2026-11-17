<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Authentication extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gatekeeper(): BelongsTo
    {
        return $this->belongsTo(Gatekeeper::class);
    }
}
