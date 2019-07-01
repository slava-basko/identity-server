<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class CanNotDeleteRoleThatInUseException extends \LogicException
{
    protected $message = 'Can\'t delete Role that in use.';
    protected $code = -32009;
}