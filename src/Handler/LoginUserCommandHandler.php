<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\LoginUserCommand;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;

class LoginUserCommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    /**
     * LoginUserCommandHandler constructor.
     * @param UserRepository $userRepository
     * @param TokenRepository $tokenRepository
     */
    public function __construct(
        UserRepository $userRepository,
        TokenRepository $tokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param LoginUserCommand $command
     */
    public function handle(LoginUserCommand $command)
    {
        $user = $this->userRepository->getUserByEmail($command->getEmail());
        $token = $this->tokenRepository->createNewFor($user);
        $this->tokenRepository->save($token);
    }
}