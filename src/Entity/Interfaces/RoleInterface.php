<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity\Interfaces;

interface RoleInterface
{
    /**
     * @param PermissionInterface $searchedPermission
     * @return PermissionInterface
     */
    public function getPermission(PermissionInterface $searchedPermission): PermissionInterface;
}
