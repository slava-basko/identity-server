<?php

namespace App\Utils;

class PostInstal
{
    public static function check()
    {
        if (!isset($_ENV['ALGORITHM_PASSWORD_HASHING']) || !in_array($_ENV['ALGORITHM_PASSWORD_HASHING'], Password::$supportedAlgorithmsHashing)) {
            echo 'Set the environment variable ALGORITHM_PASSWORD_HASHING. Possible values: ' . implode(', ', Password::$supportedAlgorithmsHashing) .'. '. PHP_EOL;
        }
    }
}