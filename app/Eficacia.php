<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eficacia extends Model
{
    //
    protected $table="eficacias";

    public function medium_term_programing()
    {
        return $this->belongsTo('App\MediumTermPrograming','pmp_id');
    }
}
