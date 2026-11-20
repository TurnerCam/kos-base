<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('user_id', 'type', 'name', 'expiry_date')]
class UserCert extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const CERT_FIRST_AID = 'firstaid';

    public const CERT_PROFESSIONAL = 'professional';

    public const CERT_HEALTH_AND_SAFETY = 'healthsafety';

    public const CERT_OTHER = 'other';

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
