<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\DeleteUserCommand;
use App\Repository\UserRepository;

class DeleteUserCommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DeleteUserCommandHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserCommand $command
     */
    public function handle(DeleteUserCommand $command)
    {
        $user = $this->userRepository->getUserByEmail($command->getEmail());
        $this->userRepository->delete($user);
    }
}