<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Query;

use App\Entity\User;
use App\Repository\UserRepository;

class UserQuery
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CreateUserCommandHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    /**
     * @param string $email
     * @return array
     */
    public function getUser(string $email)
    {
        return $this->userRepository->getUser($email);
    }
}