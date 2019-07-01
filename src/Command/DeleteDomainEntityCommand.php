<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

class DeleteDomainEntityCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * DeleteDomainEntityCommand constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}