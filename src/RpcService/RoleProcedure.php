<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\DeleteRoleCommand;
use App\Command\SaveRoleFromNameAndPermissionsAliasesCommand;
use App\Query\RoleQuery;
use Is\Sdk\Service\Interfaces\RoleService;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class RoleProcedure implements RoleService
{
    /**
     * @var MessageBusSupportingMiddleware
     */
    private $commandBus;
    /**
     * @var RoleQuery
     */
    private $roleQuery;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     * @param RoleQuery $roleQuery
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus,
        RoleQuery $roleQuery
    )
    {
        $this->commandBus = $commandBus;
        $this->roleQuery = $roleQuery;
    }

    /**
     * @param string $name
     * @param array $permissions Aliases of permissions
     * @return bool
     */
    public function save($name, array $permissions)
    {
        $command = new SaveRoleFromNameAndPermissionsAliasesCommand($name, $permissions);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->roleQuery->getList();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete($name)
    {
        $command = new DeleteRoleCommand($name);
        $this->commandBus->handle($command);
        return true;
    }
}