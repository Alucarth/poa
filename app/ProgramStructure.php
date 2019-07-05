<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramStructure extends Model
{
    //
    protected $table = "programmatic_structures";

    public function programatic_operations()
    {
        return $this->hasMany('App\ProgrammaticOperation','programmatic_structure_id');
    }
}
