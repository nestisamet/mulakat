<?php

namespace App\Http\Validation\Auth;

trait AuthValidation
{
    /**
     * @param $val
     */
    public function _password(& $val)
    {
        $val = Hash::make($val);
    }
}