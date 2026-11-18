<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable('user_id', 'skill')]
class UserSkill extends Model
{
    public function user(): HasOne
    {
        return $this->hasOne(\App\Models\User::class);
    }

    // return users matching skill name
    public function users()
    {
        $user_ids = \App\Models\UserSkill::where(['skill' => $this->skill])->pluck('user_id')->toArray();
        if (count($user_ids) > 0) {
            $result = \App\Models\User::where('status', 'active')->orderby('first_preferred')->find($user_ids);

            return $result;
        } else {
            return null;
        }
    }
}
