<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRank extends Model
{
    public function teacher()
    {
        return $this->belongsToMany('App\Models\Teacher');
    }
}
