<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\ChangeUserRolesCommand;
use App\Command\CreateUserCommand;
use App\Command\DeleteUserCommand;
use App\Command\ResetUserPasswordCommand;
use App\Query\UserQuery;
use Is\Sdk\Service\Interfaces\UserService;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class UserProcedure implements UserService
{
    /**
     * @var MessageBusSupportingMiddleware
     */
    private $commandBus;

    /**
     * @var UserQuery
     */
    private $userQuery;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     * @param UserQuery $userQuery
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus,
        UserQuery $userQuery
    )
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function register($email, $password)
    {
        $command = new CreateUserCommand($email, $password);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @param string $email
     * @param string $newPassword
     * @return bool
     */
    public function resetPassword($email, $newPassword)
    {
        $command = new ResetUserPasswordCommand($email, $newPassword);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @param string $email
     * @param string[] $roles
     * @return bool
     */
    public function assignRoles($email, array $roles)
    {
        $command = new ChangeUserRolesCommand($email, $roles);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function delete($email)
    {
        $command = new DeleteUserCommand($email);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @param string $email
     * @return array
     */
    public function getUserRoles(string $email)
    {
        return $this->userQuery->getUserRoles($email);
    }
}