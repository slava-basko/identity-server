<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class CreateDomainEntityCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * CreateDomainEntityCommand constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        v::alnum('_')
            ->length(2)
            ->lowercase()
            ->noWhitespace()
            ->assert($name);
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
