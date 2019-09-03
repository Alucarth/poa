<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificTaskProgrammation extends Model
{
    //
    public function programming()
    {
        return $this->belongsTo('App\Programming')->with('month');
    }
}
