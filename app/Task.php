<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    public function programmings()
    {
        // return $this->hasMany('App\Programming','task_id');
        return $this->belongsToMany('App\Month','programmings','task_id','month_id')
                    ->withPivot('meta','executed','efficacy');
    }
}
