<?php

namespace App\Providers;

use App\HomeContent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; //Import Schema

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

        $home = HomeContent::first();

        view()->composer(['layouts.master', 'layouts.master-auth'], function($view) use ($home)  {
        $view
            ->with('home', $home);
            
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
