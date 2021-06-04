<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionStudent extends Model
{
    protected $table = 'section_students';

    protected $guarded = [];

    public function student()
    {
        return $this->belongsToMany('App\Models\Student');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
}
