<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class WrongAlgorithmPasswordHashException extends \LogicException
{
    protected $message = 'Wrong algorithm password hash.';
    protected $code = -32018;
}