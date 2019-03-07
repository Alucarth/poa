<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgrammaticStructure extends Model
{
    //
    public function programmatic_operations()
    {
        return $this->hasMany('App\ProgrammaticOperation','programmatic_structure_id');
    }
}
