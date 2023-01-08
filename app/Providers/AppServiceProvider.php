<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Helper\LogActivity;

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

            view()->composer(['layouts.admin','layouts.app'], function($view) {
                $view->with(['contents' => LogActivity::allLog()]);
            });


            view()->composer(['layouts.employee','layouts.manager','layouts.guest'], function($view) {
                $view->with(['contents' => LogActivity::showlog(Auth::user()->id)]);
            });




    }
}
