<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Value;

use App\Entity\Interfaces\PermissionInterface;
use App\Entity\Interfaces\RoleInterface;
use App\Exceptions\Logic\NoPermissionFoundException;

class DefaultRole implements RoleInterface
{
    /**
     * @param PermissionInterface $searchedPermission
     * @return PermissionInterface
     * @throws \Exception
     */
    public function getPermission(PermissionInterface $searchedPermission): PermissionInterface
    {
        throw new NoPermissionFoundException();
    }
}
