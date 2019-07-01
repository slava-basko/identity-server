<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Utils;

use App\Exceptions\SystemException;

class Password
{
    /**
     * @param $password
     * @return bool|string
     * @throws SystemException
     */
    public static function hash($password)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        if ($passwordHash === false) {
            throw new SystemException ();
        }
        
        return $passwordHash;
    }
}
