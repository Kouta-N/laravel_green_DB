<?php

namespace App\Providers;

use App\MyClasses\MyService;
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
        app()->singleton('App\MyClasses\MyService',function($app){
            $my_service = new MyService();
            $my_service->setId(0);
            return $my_service;
        });
    }
}