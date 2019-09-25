<?php

namespace App\Listeners\Auth;

use App\Events\Auth\ValidAuthentication;
use App\Repository\Contracts\LoginActivityRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueuRequeste;

class ListenerAuthActivity
{
    private $storage;

    /**
     * ListenerAuthActivity constructor.
     * @param LoginActivityRepository $storage
     */
    public function __construct(LoginActivityRepository $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Handle the event.
     *
     * @param  ValidAuthentication  $event
     * @return void
     */
    public function handle(ValidAuthentication $event)
    {
        $this->storage->create([
            'token' => $event->token,
            'user_id'    =>  auth()->user()->id,
            'user_email' =>  auth()->user()->email,
            'user_agent' =>  Request::header('User-Agent'),
            'ip_address' =>  Request::ip()
        ]);
    }
}
