<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;
use App\Value\User\AdditionalData;

class LoginUserCommand
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
     * @var AdditionalData
     */
    private $additionalData = null;

    /**
     * LoginUserCommand constructor.
     * @param string $email
     * @param string $password
     * @param array $additionalData
     */
    public function __construct(string $email, string $password, array $additionalData)
    {
        v::email()->assert($email);
        v::notEmpty()->assert($password);

        $this->email = $email;
        $this->password = $password;
        $this->additionalData = new AdditionalData($additionalData);
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return AdditionalData
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }
}