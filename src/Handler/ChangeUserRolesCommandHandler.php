<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\ChangeUserRolesCommand;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;

class ChangeUserRolesCommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * CreateUserCommandHandler constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param ChangeUserRolesCommand $command
     */
    public function handle(ChangeUserRolesCommand $command)
    {
        $roles = [];
        foreach ($command->getRolesNames() as $rolesName) {
            $roles[] = $this->roleRepository->getRoleByName($rolesName);
        }

        $user = $this->userRepository->getUserByEmail($command->getEmail());
        $user->changeRoles($roles);

        $this->userRepository->save($user);
    }
}