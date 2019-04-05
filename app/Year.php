<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    //
    public function action_medium_term()
    {
        return  $this->belongsTo('App\ActionMediumTerm','action_medium_term_id');
    }

    public function action_short_terms()
    {
        return $this->hasMany('App\ActionShortTerm','year_id');
    }
}
