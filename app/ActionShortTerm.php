<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ActionShortTerm extends Model
{
    //
    use SoftDeletes;
    public function operations()
    {
        return $this->hasMany('App\Operation','action_short_term_id');
    }
    public function year()
    {
        return $this->belongsTo('App\Year');
    }
    public function programmatic_structure()
    {
        return $this->belongsTo('App\ProgrammaticStructure');
    }
}
