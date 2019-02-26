<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediumTermPrograming extends Model
{
    //
    protected $table='programacion_medio_plazo';
    
    public function short_term_programing()
    {
        return $this->belongsTo('App\ShortTermPrograming','pmp_id');    
    }
    
}
