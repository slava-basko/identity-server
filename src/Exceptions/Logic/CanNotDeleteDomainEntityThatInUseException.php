<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class CanNotDeleteDomainEntityThatInUseException extends \LogicException
{
    protected $message = 'Can\'t delete DomainEntity that in use.';
    protected $code = -32005;
}