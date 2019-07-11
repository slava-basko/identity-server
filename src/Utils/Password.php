<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Utils;

use App\Exceptions\Logic\WrongAlgorithmPasswordHashException;
use App\Exceptions\SystemException;

class Password
{

    /**
     * @var array
     */
    public static $supported_algorithms_hashing = ['bcrypt', 'md5'];

    /**
     * @param $password
     * @return bool|string
     * @throws SystemException
     */
    public static function hash($password)
    {
        if(!isset($_ENV['ALGORITHM_PASSWORD_HASHING']) || !in_array($_ENV['ALGORITHM_PASSWORD_HASHING'], self::$supported_algorithms_hashing)){
            throw new WrongAlgorithmPasswordHashException();
        }
        $algorithm = $_ENV['ALGORITHM_PASSWORD_HASHING'];
        return self::$algorithm($password);
    }

    /**
     * @param $password
     * @return string
     */
    private static function md5($password){
        return md5($password);
    }

    /**
     * @param $password
     * @return bool|false|string
     * @throws SystemException
     */
    private static function bcrypt($password){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        if ($passwordHash === false) {
            throw new SystemException ();
        }
        return $passwordHash;
    }
}
