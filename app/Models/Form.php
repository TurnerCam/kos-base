<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('name', 'description', 'status', 'special_form', 'fields', 'conditions', 'actions')]
class Form extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmissions::class);
    }

    //
}
