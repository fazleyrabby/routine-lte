<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsToMany('App\Teacher');
    }

    public function batch()
    {
        return $this->belongsToMany('App\Batch');
    }

}
