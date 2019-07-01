<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class DomainEntityNotExistException extends \LogicException
{
    protected $message = 'Domain Entity not exist.';
    protected $code = -32002;
}