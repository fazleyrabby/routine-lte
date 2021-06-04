<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch');
    }

    public function section_student()
    {
        return $this->hasMany('App\Models\SectionStudent');
    }

    public function yearly_session()
    {
        return $this->belongsTo('App\Models\YearlySession');
    }

}
