<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayWiseSlot extends Model
{
    protected $guarded = [];

    public function day()
    {
        return $this->belongsTo('App\Models\Day');
    }

    public function time_slot()
    {
        return $this->belongsTo('App\Models\TimeSlot');
    }

//    public function routine()
//    {
//        return $this->belongsTo('App\Models\FullRoutine');
//    }

}
