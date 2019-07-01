<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class RoleNotExistException extends \LogicException
{
    protected $message = 'Role not exist.';
    protected $code = -32008;
}