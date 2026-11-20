<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

#[Fillable('user_id', 'gatekeeper_id')]
class Trainers extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // returns the name of the trainer this record is for
    public function name()
    {
        $result = \App\Models\User::where('id', $this->user_id)->get();

        foreach ($result->pluck('first_name', 'last_name') as $lastname => $firstname) {
            $full_name = $firstname.' '.$lastname;
        }

        return $full_name;
    }

    // returns the name of the gatekeeper the training record is for
    public function gatekeeper()
    {
        $result = \App\Models\Gatekeeper::where('id', $this->gatekeeper_id)->get();

        return $result->pluck('name');
    }
}
