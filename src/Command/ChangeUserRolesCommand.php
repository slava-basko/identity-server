<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class ChangeUserRolesCommand
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var array
     */
    private $rolesNames;

    /**
     * ChangeUserRolesCommand constructor.
     * @param string $email
     * @param array $rolesNames
     */
    public function __construct(string $email, array $rolesNames)
    {
        v::email()->assert($email);

        $this->email = $email;
        $this->rolesNames = $rolesNames;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRolesNames(): array
    {
        return $this->rolesNames;
    }
}