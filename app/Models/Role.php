<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('roles')]
#[Fillable('name', 'description', 'permissions')]
class Role extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const ROLE_SUPERUSER_NAME = 'Superusers';

    public const ROLE_BOD_NAME = 'BoD';

    public const ROLE_KEY_FOB_ASSIGNER_NAME = 'Key fob assigners';

    public const ROLE_BOOKKEEPER_NAME = 'Bookkeeper';



    public function permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
