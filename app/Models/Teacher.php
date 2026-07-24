<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function rank()
    {
        return $this->belongsTo('App\Models\TeacherRank');
    }

    public function teachers_offday()
    {
        return $this->hasMany('App\Models\TeachersOffday');
    }


}


