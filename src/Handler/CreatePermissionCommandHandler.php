<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\CreatePermissionCommand;
use App\Repository\PermissionRepository;

class CreatePermissionCommandHandler
{
    /**
     * @var PermissionRepository
     */
    private $repository;

    /**
     * CreatePermissionCommandHandler constructor.
     * @param PermissionRepository $repository
     */
    public function __construct(
        PermissionRepository $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @param CreatePermissionCommand $command
     */
    public function handle(CreatePermissionCommand $command)
    {
        $permission = $this->repository->createNew(
            $command->getOperation(),
            $command->getDomainEntity(),
            $command->getBusinessRules()
        );
        $this->repository->save($permission);
    }
}
