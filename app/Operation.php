<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    //
    public function tasks() 
    {
        return $this->hasMany('App\Task','operation_id');
    }

    public function action_short_term()
    {
        return $this->belongsTo('App\ActionShortTerm');
    }
}
