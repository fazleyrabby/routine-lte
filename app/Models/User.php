<?php

namespace App\Models;

use App\Models\RoutineCommittee;
use App\Notifications\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teacher(){
        return $this->hasOne('App\Models\Teacher');
    }

    public function sender()
    {
        return $this->hasOne(RoutineCommittee::class,'sender_id');
    }
    public function receiver()
    {
        return $this->hasOne(RoutineCommittee::class,'receiver_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
