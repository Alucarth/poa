<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediumTermPrograming extends Model
{
    //
    protected $table='programacion_medio_plazo';
    
    public function ShortTermPrograming()
    {
        return $this->hasOne('App\ShortTermPrograming');    
    }
}
