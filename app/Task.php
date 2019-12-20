<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    public function programmings()
    {
        return $this->hasMany('App\Programming','task_id');
        // return $this->belongsToMany('App\Month','programmings','task_id','month_id')
        //             ->withPivot('id','meta','executed','efficacy','operation_programming_id');
    }
    public function operation()
    {
        return $this->belongsTo("App\Operation");
    }
}
