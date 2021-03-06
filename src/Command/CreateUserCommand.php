<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class CreateUserCommand
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * CreateUserCommand constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        v::email()->assert($email);
        v::stringType()->length(4)->assert($password);

        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
}