<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\LoginUserCommand;
use App\Query\PermissionQuery;
use App\Query\TokenQuery;
use App\Query\UserQuery;
use App\Value\Factory\TokenFactory;
use Is\Sdk\Auth\Token;
use Is\Sdk\Value\Answer;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class AuthService implements \Is\Sdk\Service\Interfaces\AuthService
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
     * @var TokenQuery
     */
    private $tokenQuery;
    /**
     * @var PermissionQuery
     */
    private $permissionQuery;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     * @param UserQuery $userQuery
     * @param TokenQuery $tokenQuery
     * @param PermissionQuery $permissionQuery
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus,
        UserQuery $userQuery,
        TokenQuery $tokenQuery,
        PermissionQuery $permissionQuery
    )
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
        $this->tokenQuery = $tokenQuery;
        $this->permissionQuery = $permissionQuery;
    }

    /**\
     * @param string $email
     * @param string $password
     * @param array|null $additionalData
     * @return Token|mixed
     */
    public function login($email, $password, $additionalData = null)
    {
        $additionalData = is_array($additionalData) ? $additionalData :[];
        $command = new LoginUserCommand($email, $password, $additionalData);
        $this->commandBus->handle($command);

        $user = $this->userQuery->getUserByEmail($email);
        $token = $this->tokenQuery->getUserToken($user);
        return TokenFactory::valueObjectFromEntity($token);
    }

    /**
     * @param string $permissionAlias
     * @param string $token
     * @return Answer
     */
    public function checkPermission($permissionAlias, $token)
    {
        $permission = $this->permissionQuery->getPermissionByAlias($permissionAlias);
        $token = $this->tokenQuery->getToken($token);
        return $token->isTokenOwnerHasPermission($permission);
    }
}