<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\Role;
use App\Exceptions\Logic\CanNotDeleteRoleThatInUseException;
use App\Exceptions\Logic\RoleExistException;
use App\Exceptions\Logic\RoleNotExistException;
use App\Repository\Traits\EntityPersistStateTrait;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param string $name
     * @return Role
     */
    public function getRoleByName(string $name): Role
    {
        $domainEntity = $this->findOneBy(['name' => $name]);
        if (!($domainEntity instanceof Role)) {
            throw new RoleNotExistException();
        }
        return $domainEntity;
    }

    /**
     * @param string $name
     * @param array $permissions
     * @return Role
     */
    public function createNew(string $name, array $permissions): Role
    {
        $domainEntity = $this->findOneBy(['name' => $name]);
        if ($domainEntity instanceof Role) {
            throw new RoleExistException();
        }
        return new Role($name, $permissions);
    }

    /**
     * @return \Generator
     */
    public function getPlainList(): \Generator
    {
        $roles = $this->createQueryBuilder('r')
            ->select('r.name')
            ->getQuery()
            ->getArrayResult();
        foreach ($roles as $roleRow) {
            yield $roleRow['name'];
        }
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function delete(Role $role): bool
    {
        try {
            $this->getEntityManager()->remove($role);
            $this->getEntityManager()->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            throw new CanNotDeleteRoleThatInUseException();
        }
        return true;
    }
}