<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class TokenNotExistException extends \LogicException
{
    protected $message = 'Token not exist.';
    protected $code = -32014;
}