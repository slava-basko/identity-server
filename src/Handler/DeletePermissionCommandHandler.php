<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\DeletePermissionCommand;
use App\Repository\PermissionRepository;

class DeletePermissionCommandHandler
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * DeletePermissionCommandHandler constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        PermissionRepository $permissionRepository
    )
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param DeletePermissionCommand $command
     */
    public function handle(DeletePermissionCommand $command)
    {
        $permission = $this->permissionRepository->getPermissionByAlias($command->getAlias());
        $this->permissionRepository->delete($permission);
    }
}