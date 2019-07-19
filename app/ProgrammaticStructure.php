<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProgrammaticStructure extends Model
{
    //
    use SoftDeletes;

    public function programmatic_operations()
    {
        return $this->hasMany('App\ProgrammaticOperation','programmatic_structure_id');
    }
}
