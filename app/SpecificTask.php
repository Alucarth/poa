<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificTask extends Model
{
    //
    public function specific_task_programmations()
    {
        $this->hasMany('App\SpecificTaskProgrammation','id');
    }
}
