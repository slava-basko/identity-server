<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Query;

use App\Entity\Permission;
use App\Repository\PermissionRepository;

class PermissionQuery
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * PermissionQuery constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        PermissionRepository $permissionRepository
    )
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return iterator_to_array($this->permissionRepository->getPlainList());
    }

    /**
     * @param string $alias
     * @return Permission
     */
    public function getPermissionByAlias(string $alias): Permission
    {
        return $this->permissionRepository->getPermissionByAlias($alias);
    }
}