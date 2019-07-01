<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Repository\UserRepository;

class CreateUserCommandHandler
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
     * @param CreateUserCommand $command
     */
    public function handle(CreateUserCommand $command)
    {
        $user = $this->userRepository->createNew($command->getEmail(), $command->getPassword());
        $this->userRepository->save($user);
    }
}
