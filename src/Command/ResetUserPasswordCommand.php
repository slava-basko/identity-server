<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class ResetUserPasswordCommand
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $newPassword;

    /**
     * ResetUserPasswordCommand constructor.
     * @param string $email
     * @param string $newPassword
     */
    public function __construct(string $email, string $newPassword)
    {
        v::email()->assert($email);
        v::stringType()->length(4)->assert($newPassword);

        $this->email = $email;
        $this->newPassword = $newPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}