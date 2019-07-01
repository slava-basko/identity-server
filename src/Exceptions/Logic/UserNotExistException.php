<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class UserNotExistException extends \LogicException
{
    protected $message = 'User not exist.';
    protected $code = -32012;
}