<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Query;

use App\Repository\RoleRepository;

class RoleQuery
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleQuery constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        RoleRepository $roleRepository
    )
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return iterator_to_array($this->roleRepository->getPlainList());
    }
}