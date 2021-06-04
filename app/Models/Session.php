<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public function shift()
    {
        return $this->belongsToMany('App\Models\Shift');
    }
}
