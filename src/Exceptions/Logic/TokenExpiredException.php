<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class TokenExpiredException extends \LogicException
{
    protected $message = 'Token expired.';
    protected $code = -32015;
}