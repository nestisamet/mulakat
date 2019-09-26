<?php

namespace App\Providers;

use App\Events\Auth\ValidAuthentication;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /**
         * event: basarili otorizasyon
         */
        ValidAuthentication::class => [
            'App\Listeners\Auth\ListenerAuthActivity',
        ],
        /**
         * event: ogrenci yaratma
         */
        \App\Events\Student\StudentCreated::class => [
            'App\Listeners\Student\ListenerStudentCreated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
