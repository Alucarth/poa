<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Year;
class ActionMediumTerm extends Model
{
    //
    use SoftDeletes;

    public function years()
    {
        return $this->hasMany('App\Year','action_medium_term_id')->orderBy('year');
    }
    public function year()
    {
        $year = Year::where('action_medium_term_id',$this->id)->where('year',Carbon::now()->year)->first();
        if(!$year)
        {
            $year = $this->years[0];
        }

        return $year;
    }

    public function programmatic_structure()
    {
        return $this->belongsTo('App\ProgrammaticStructure');
    }
}
