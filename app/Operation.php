<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Operation extends Model
{
    //
    use SoftDeletes;
    public function tasks()
    {
        return $this->hasMany('App\Task','operation_id');
    }

    public function action_short_term()
    {
        return $this->belongsTo('App\ActionShortTerm');
    }

    public function programmatic_operations()
    {
        return $this->belongsToMany('App\ProgrammaticOperation','operation_programmations','operation_id','programmatic_operation_id');
    }
}
