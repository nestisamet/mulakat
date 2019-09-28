<?php

namespace App\Http\Validation\Auth;

trait AuthValidation
{
    /**
     * @param $val
     */
    public function password(& $val)
    {
        $val = Hash::make($val);
    }
}
