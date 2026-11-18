<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('user_id', 'role_id', 'team_id', 'team_role', 'gatekeeper_id', 'status', 'approved_by')]
class TeamAssignment extends Model implements Auditable
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

    public function gatekeeper(): HasOne
    {
        return $this->hasOne(Gatekeeper::class, 'id', 'gatekeeper_id');
    }
}
