<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class CanNotDeleteEntityEntryThatInUseException extends \LogicException
{
    protected $message = 'Can\'t delete EntityEntry that in use.';
    protected $code = -32017;
}