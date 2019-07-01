<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Exceptions\Logic\RoleNotExistException;
use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;
use App\Command\SaveRoleFromNameAndPermissionsAliasesCommand;

class SaveRoleFromNameAndPermissionsAliasesCommandHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * CreateRoleFromNameAndPermissionsAliasesCommandHandler constructor.
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param SaveRoleFromNameAndPermissionsAliasesCommand $command
     */
    public function handle(SaveRoleFromNameAndPermissionsAliasesCommand $command)
    {
        $permissions = [];
        foreach ($command->getPermissionsAliases() as $alias) {
            $permissions[] = $this->permissionRepository->getPermissionByAlias($alias);
        }

        try {
            $role = $this->roleRepository->getRoleByName($command->getName());
            $role->resetPermissions($permissions);
        } catch (RoleNotExistException $ex) {
            $role = $this->roleRepository->createNew($command->getName(), $permissions);
        }

        $this->roleRepository->save($role);
    }
}