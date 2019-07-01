<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Exceptions\Logic;

class EntityEntryExistException extends \LogicException
{
    protected $message = 'Entity entry already exist.';
    protected $code = -32016;
}