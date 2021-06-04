<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            $requests = '';
            $y_session = DB::table('yearly_sessions')
                ->join('sessions', 'yearly_sessions.session_id', '=', 'sessions.id')
                ->select('yearly_sessions.*','sessions.session_name')
                ->where('yearly_sessions.is_active','yes')
                ->get();


            if(request()->user()){
                $requests = DB::table('routine_committee_requests')
                    ->where('receiver_id', request()->user()->id)
                    ->get();
            }

            $view->with('requests', $requests)->with('y_session',$y_session);
        });
    }
}
