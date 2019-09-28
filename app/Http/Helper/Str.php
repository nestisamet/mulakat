<?php

namespace App\Http\Helper;

class Str
{
    /**
     * @param $str
     * @return string|string[]|null
     */
    public static function underscoreToCamelCase($str)
    {
        return preg_replace_callback('/(?!^)_([a-z])/', function ($match) {
                return strtoupper($match[1]);
        }, $str);
    }
}
