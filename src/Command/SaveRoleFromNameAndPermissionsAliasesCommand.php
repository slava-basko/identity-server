<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class SaveRoleFromNameAndPermissionsAliasesCommand
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $permissionsAliases;

    /**
     * CreateRoleFromNameAndPermissionsAliasesCommand constructor.
     * @param string $name
     * @param array $permissionsAliases
     */
    public function __construct(string $name, array $permissionsAliases)
    {
        v::stringType()->length(2)->lowercase()->assert($name);
        v::arrayType()->assert($permissionsAliases);

        $this->name = $name;
        $this->permissionsAliases = $permissionsAliases;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPermissionsAliases(): array
    {
        return $this->permissionsAliases;
    }
}