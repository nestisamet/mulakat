<?php

namespace App\Listeners\Student;

use \App\Notifications\StudentCreated;
use App\Model\Account;
use App\Notifications\AccountCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerStudentCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(\App\Events\Student\StudentCreated $event)
    {
        auth()->user()->notify(new StudentCreated($event->student));
    }
}
