<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $guarded = ['id'];

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

    public function scopeWithBatchDetails($query)
    {
        return $query->select('students.*', 'sections.id as section_id', 'batch.id as batch_id')
            ->leftJoin('section_students', 'section_students.student_id', '=', 'students.id')
            ->leftJoin('sections', 'sections.id', '=', 'section_students.section_id')
            ->leftJoin('batch', 'students.batch_id', '=', 'batch.id')
            ->leftJoin('shifts', 'shifts.id', '=', 'batch.shift_id')
            ->leftJoin('departments', 'departments.id', '=', 'batch.department_id')
            ->leftJoin('yearly_sessions', 'yearly_sessions.id', '=', 'students.yearly_session_id')
            ->leftJoin('shift_sessions', 'shift_sessions.session_id', '=', 'yearly_sessions.session_id');
    }
}
