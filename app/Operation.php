<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Operation extends Model
{
    //
    use SoftDeletes;

    public function operation_programmings()
    {
        // return $this->hasMany('App\Programming','task_id');
        return $this->belongsToMany('App\Month','operation_programmings','operation_id','month_id')
                    ->withPivot('id','meta','executed','efficacy');
    }
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
