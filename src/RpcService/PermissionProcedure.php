<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\CreatePermissionCommand;
use App\Command\DeletePermissionCommand;
use App\Exceptions\Logic\DomainEntityNotExistException;
use App\Query\PermissionQuery;
use App\Repository\DomainEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Is\Sdk\Service\Interfaces\PermissionService;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class PermissionProcedure implements PermissionService
{
    /**
     * @var MessageBusSupportingMiddleware
     */
    private $commandBus;

    /**
     * @var DomainEntityRepository
     */
    private $domainEntityRepository;

    /**
     * @var PermissionQuery
     */
    private $permissionQuery;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     * @param DomainEntityRepository $domainEntityRepository
     * @param PermissionQuery $permissionQuery
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus,
        DomainEntityRepository $domainEntityRepository,
        PermissionQuery $permissionQuery
    )
    {
        $this->commandBus = $commandBus;
        $this->domainEntityRepository = $domainEntityRepository;
        $this->permissionQuery = $permissionQuery;
    }

    /**
     * @param string $operation
     * @param string $domainEntity
     * @param array $bizRules
     * @return bool
     */
    public function create($operation, $domainEntity, array $bizRules = [])
    {
        try {
            $domainEntity = $this->domainEntityRepository->getDomainEntityByName($domainEntity);

            $command = new CreatePermissionCommand($operation, $domainEntity, $bizRules);
            $this->commandBus->handle($command);
        } catch (EntityNotFoundException $ex) {
            throw new DomainEntityNotExistException();
        }

        return true;
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function delete($alias)
    {
        $command = new DeletePermissionCommand($alias);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->permissionQuery->getList();
    }
}
