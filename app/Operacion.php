<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    //
    protected $table='operaciones';

    public function short_term_programing(){
        return $this->belongsTo('App\ShortTermPrograming','pcp_id');
    }
}
