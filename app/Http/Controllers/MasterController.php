<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class MasterController extends Controller
{
    public function __construct()
    {

//        $y_session = DB::table('yearly_sessions')
//            ->join('sessions', 'yearly_sessions.session_id', '=', 'sessions.id')
//            ->select('yearly_sessions.*','sessions.session_name')
//            ->where('yearly_sessions.is_active','yes')
//            ->get();
//
////
//
//
//        View::share('y_session' ,$y_session);
    }

}
