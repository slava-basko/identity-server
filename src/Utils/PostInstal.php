<?php

namespace App\Utils;

class PostInstal
{
    public static function check()
    {
        if (!isset($_ENV['algorithmPasswordHashing']) || !in_array($_ENV['algorithmPasswordHashing'], Password::$supported_algorithms_hashing)) {
            echo 'Set the environment variable algorithmPasswordHashing. Possible values: ' . implode(', ', Password::$supported_algorithms_hashing) .'. '. PHP_EOL;
        }
    }
}