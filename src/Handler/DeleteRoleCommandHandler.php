<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\DeleteRoleCommand;
use App\Repository\RoleRepository;

class DeleteRoleCommandHandler
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * DeleteRoleCommandHandler constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        RoleRepository $roleRepository
    )
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param DeleteRoleCommand $command
     */
    public function handle(DeleteRoleCommand $command)
    {
        $role = $this->roleRepository->getRoleByName($command->getName());
        $this->roleRepository->delete($role);
    }
}