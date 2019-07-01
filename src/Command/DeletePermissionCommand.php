<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;


class DeletePermissionCommand
{
    /**
     * @var string
     */
    private $alias;

    /**
     * DeletePermissionCommand constructor.
     * @param string $alias
     */
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
}