<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Repositories\GlobalRepository;
//use App\Repositories\GlobalEloquent;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton(GlobalRepository::class,GlobalEloquent::class);
    }
}
