<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;


class PermissionExistException extends \LogicException
{
    protected $message = 'Permission already exist.';
    protected $code = -32003;
}