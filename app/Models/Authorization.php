<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Authorization extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gatekeeper(): HasOne
    {
        return $this->hasOne(Gatekeeper::class, 'id', 'gatekeeper_id');
    }

    // returns the name of the gatekeeper this authorization is for
    public function name()
    {
        $result = \App\Models\Gatekeeper::where('id', $this->gatekeeper_id)->get();

        return $result->pluck('name');
    }
}
