<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificTaskProgrammation extends Model
{
    //
    public function programmaing()
    {
        return $this->belongsTo('App\Programming');
    }
}
