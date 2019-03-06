<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionShortTerm extends Model
{
    //
    public function operations()
    {
        return $this->hasMany('App\Operation','action_short_term_id');
    }
    public function year()
    {
        return $this->belongsTo('App\Year');
    }
}
