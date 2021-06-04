<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignCourse extends Model
{
    protected $guarded = [];

    protected $table = 'assign_courses_to_teachers';

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function session()
    {
        return $this->belongsTo('App\Models\YearlySession');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function batch(){
        return $this->belongsTo('App\Models\Batch');
    }


}
