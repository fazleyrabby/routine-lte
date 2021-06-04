<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSession extends Model
{
    protected $table = 'shift_sessions';

    protected $guarded = [];

    public function shift()
    {
        return $this->belongsTo('App\Models\Shift');
    }

    public function session()
    {
        return $this->belongsTo('App\Models\Session');
    }

    public function yearly_session(){
        return $this->belongsTo('App\Models\YearlySession');
    }
}
