<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortTermPrograming extends Model
{
    //
    protected $table='programacion_corto_plazo'; 

    public function medium_term_programing() //relacion con el medio plazo no tocar 
    {
        return $this->belongsTo('App\MediumTermPrograming', 'programacion_medio_plazo_id');
    }
    public function indicadores()
    {
        return $this->belongsToMany('App\PcpIndicator','programacion_corto_plazo_id');
    }
}
