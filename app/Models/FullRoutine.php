<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FullRoutine extends Model
{
    protected $table = 'routine';

    protected  $guarded = [];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch');
    }

    public function day()
    {
        return $this->belongsTo('App\Models\Day');
    }

    public function time_slot()
    {
        return $this->belongsTo('App\Models\TimeSlot');
    }

    public function y_session()
    {
        return $this->belongsTo('App\Models\YearlySession');
    }


}
