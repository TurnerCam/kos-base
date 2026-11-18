<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('request_type', 'status', 'user_id', 'team_id', 'gatekeeper_id')]
class TeamRequest extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // returns gatekeeper object of current request
    public function gatekeeper(): BelongsTo
    {
        return $this->belongsTo(Gatekeeper::class, 'gatekeeper_id', 'id');
    }
}
