<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()){
            return redirect('home');
        }
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'){
            return $next($request);
        }
        return abort(404);
    }
}
