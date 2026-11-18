<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('user_id', 'flag')]
class UserFlag extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const FLAG_COVID_VACCINE = 'covid_vaccine';

    public const FLAG_KEYS_DISABLED = 'keys_disabled';


    public function user(): HasOne
    {
        return $this->hasOne(\App\Models\User::class);
    }
}
