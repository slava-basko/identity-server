<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class NoPermissionFoundException extends \LogicException
{
    protected $message = 'No permissions found.';
    protected $code = -32004;
}