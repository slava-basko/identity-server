<?php

namespace App\Utils;

class Env
{
    public static function get($var)
    {
        if(!isset($_ENV[$var])){
            throw new \InvalidArgumentException('Undefined environment variable: '.$var);
        }
        return $_ENV[$var];
    }
}
