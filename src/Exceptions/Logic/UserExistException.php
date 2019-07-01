<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class UserExistException extends \LogicException
{
    protected $message = 'User already exist.';
    protected $code = -32010;
}