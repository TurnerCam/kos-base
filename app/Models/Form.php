<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Form extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'description', 'status', 'special_form', 'fields', 'conditions', 'actions'];

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmissions::class);
    }

    //
}
