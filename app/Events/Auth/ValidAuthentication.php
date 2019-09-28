<?php

namespace App\Events\Auth;

use Illuminate\Queue\SerializesModels;

class ValidAuthentication
{
    use SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }
}
