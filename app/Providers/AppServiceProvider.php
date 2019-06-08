<?php

namespace App\Providers;

use App\Slot;
use App\Nominee;
use App\Position;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (App::environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('admin.slot.index', function($view){
            $view->with('positions',Position::all());
            $view->with('nominees',Nominee::all());
        });

        View::composer('admin.election.index', function($view){
            $view->with('slots',Slot::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
