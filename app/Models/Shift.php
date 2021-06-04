<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsToMany('App\Models\Batch');
    }

    public function session()
    {
        return $this->belongsToMany('App\Models\Session');
    }
}
