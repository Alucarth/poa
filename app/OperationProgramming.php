<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationProgramming extends Model
{
    //
    public function month()
    {
        return $this->belongsTo("App\Month");
    }
}
