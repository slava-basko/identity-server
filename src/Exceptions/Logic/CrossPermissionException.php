<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class CrossPermissionException extends \LogicException
{
    protected $message = 'Can not use roles with same permission for one user.';
    protected $code = -32011;
}