<?php

namespace App\Providers;

use App\Repository\AccountEloquent;
use App\Repository\Contracts\AccountRepository;
use App\Repository\Contracts\LoginActivityRepository;
use App\Repository\Contracts\StudentRepository;
use App\Repository\LoginActivityEloquent;
use App\Repository\StudentEloquent;
use Illuminate\Http\Resources\Json\Resource;
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
        $this->app->singleton(StudentRepository::class, StudentEloquent::class);
        $this->app->singleton(LoginActivityRepository::class, LoginActivityEloquent::class);

        Resource::withoutWrapping();
    }
}
