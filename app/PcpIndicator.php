<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PcpIndicator extends Model
{
    //
    protected $table = "indicadores_corto_plazo";

    public function ShortTermPrograming()
    {
        return $this->belongsTo('App\ShortTermPrograming');
    }
}
