<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    protected $table = 'sections';

    public function section_student()
    {
        return $this->belongsToMany('App\Models\SectionStudent');
    }
}
