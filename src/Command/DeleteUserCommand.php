<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class DeleteUserCommand
{
    /**
     * @var string
     */
    private $email;

    /**
     * DeleteUserCommand constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        v::email()->check($email);

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}