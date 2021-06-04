<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function shift()
    {
        return $this->belongsTo('App\Models\Shift');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student');
    }
}
