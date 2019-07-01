<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class RoleExistException extends \LogicException
{
    protected $message = 'Role already exist.';
    protected $code = -32007;
}