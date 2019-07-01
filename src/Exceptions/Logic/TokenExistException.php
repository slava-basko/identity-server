<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class TokenExistException extends \LogicException
{
    protected $message = 'Token already exist.';
    protected $code = -32013;
}