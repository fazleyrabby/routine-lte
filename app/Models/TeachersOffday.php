<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachersOffday extends Model
{
    protected $table = 'teachers_offday';

    protected $guarded = [];


    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function day()
    {
        return $this->belongsTo('App\Models\Day');
    }
}
