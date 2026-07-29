<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        // Cache view composer data for the lifetime of this request so DB queries
        // only run once even if many sub-views trigger the '*' composer.
        view()->composer('*', function ($view)
        {
            if (!app()->bound('_view_composer_cache')) {
                $y_session = DB::table('yearly_sessions')
                    ->join('sessions', 'yearly_sessions.session_id', '=', 'sessions.id')
                    ->select('yearly_sessions.*','sessions.session_name')
                    ->where('yearly_sessions.is_active','yes')
                    ->get();

                $requests = '';
                if (request()->user()) {
                    $requests = DB::table('routine_committee_requests')
                        ->where('receiver_id', request()->user()->id)
                        ->get();
                }

                app()->instance('_view_composer_cache', compact('y_session', 'requests'));
            }

            $cached = app('_view_composer_cache');
            $view->with('requests', $cached['requests'])->with('y_session', $cached['y_session']);
        });
    }
}
