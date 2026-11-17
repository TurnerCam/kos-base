<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class UserFlag extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const FLAG_COVID_VACCINE = 'covid_vaccine';

    public const FLAG_KEYS_DISABLED = 'keys_disabled';

    protected $fillable = ['user_id', 'flag'];

    public function user(): HasOne
    {
        return $this->hasOne(\App\Models\User::class);
    }
}
