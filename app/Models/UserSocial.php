<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    //
    protected $fillable = ['service', 'profile'];

    public function user(): HasOne
    {
        return $this->hasOne(\App\Models\User::class);
    }
}
