<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class DomainEntityExistException extends \LogicException
{
    protected $message = 'Domain Entity already exist.';
    protected $code = -32001;
}