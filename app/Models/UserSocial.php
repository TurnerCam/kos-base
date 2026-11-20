<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable('service', 'profile')]
class UserSocial extends Model
{
    public function user(): HasOne
    {
        return $this->hasOne(\App\Models\User::class);
    }
}
