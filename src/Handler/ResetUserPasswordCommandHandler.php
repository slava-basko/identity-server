<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\ResetUserPasswordCommand;
use App\Repository\UserRepository;

class ResetUserPasswordCommandHandler
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
     * @param ResetUserPasswordCommand $command
     */
    public function handle(ResetUserPasswordCommand $command)
    {
        $user = $this->userRepository->getUserByEmail($command->getEmail());
        $user->changePassword($command->getNewPassword());
        $this->userRepository->save($user);
    }
}