<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\DomainEntity;
use App\Entity\Permission;
use App\Exceptions\Logic\CanNotDeletePermissionThatInUseException;
use App\Exceptions\Logic\NoPermissionFoundException;
use App\Exceptions\Logic\PermissionExistException;
use App\Repository\Traits\EntityPersistStateTrait;
use App\Utils\Uuid;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityRepository;

class PermissionRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param string $operation
     * @param DomainEntity $domainEntity
     * @param array $businessRules
     * @return Permission
     */
    public function createNew(string $operation, DomainEntity $domainEntity, $businessRules = []): Permission
    {
        $permission = $this->findOneBy([
            'operation' => $operation,
            'domainEntity' => $domainEntity
        ]);
        if ($permission instanceof Permission) {
            throw new PermissionExistException();
        }

        return new Permission($operation, $domainEntity, $businessRules);
    }

    /**
     * @param string $alias
     * @return Permission
     */
    public function getPermissionByAlias(string $alias): Permission
    {
        $id = Uuid::hash(preg_replace('/\./', '', $alias));
        $permission = $this->find($id);
        if (!($permission instanceof Permission)) {
            throw new NoPermissionFoundException();
        }
        return $permission;
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function delete(Permission $permission): bool
    {
        try {
            $this->getEntityManager()->remove($permission);
            $this->getEntityManager()->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            throw new CanNotDeletePermissionThatInUseException();
        }
        return true;
    }

    /**
     * @return \Generator
     */
    public function getPlainList(): \Generator
    {
        $permissions = $this->createQueryBuilder('p')
            ->select('p.operation', 'de.name')
            ->leftJoin('p.domainEntity', 'de')
            ->getQuery()
            ->getArrayResult();
        foreach ($permissions as $permissionRow) {
            yield $permissionRow['operation'] . '_' . $permissionRow['name'];
        }
    }
}