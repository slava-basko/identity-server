<?php

namespace App\Utils;

class PostInstal
{
    public static function check()
    {
        if (!isset($_ENV['algorithmPasswordHashing']) || !in_array($_ENV['algorithmPasswordHashing'], Password::$supportedAlgorithmsHashing)) {
            echo 'Set the environment variable algorithmPasswordHashing. Possible values: ' . implode(', ', Password::$supportedAlgorithmsHashing) .'. '. PHP_EOL;
        }
    }
}