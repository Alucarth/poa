<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionMediumTerm extends Model
{
    //
    public function years()
    {
        return $this->hasMany('App\Year','action_medium_term_id');
    }
}
