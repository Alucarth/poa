<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programming extends Model
{
    //

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function month(){
        return $this->belongsTo('App\Month');
    }

}
