<?php

namespace App\Providers;

use App\Repository\AccountEloquent;
use App\Repository\Contracts\AccountRepository;
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
        $this->app->singleton(AccountRepository::class, AccountEloquent::class);
    }
}
