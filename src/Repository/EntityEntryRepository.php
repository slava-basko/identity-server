<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\DomainEntity;
use App\Entity\EntityEntry;
use App\Entity\User;
use App\Exceptions\Logic\CanNotDeleteEntityEntryThatInUseException;
use App\Exceptions\Logic\EntityEntryExistException;
use App\Repository\Traits\EntityPersistStateTrait;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityRepository;

class EntityEntryRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param DomainEntity $domainEntity
     * @param $entityExternalId
     * @param User $user
     * @return EntityEntry
     */
    public function createNew(DomainEntity $domainEntity, $entityExternalId, User $user): EntityEntry
    {
        $entityEntry = $this->findOneBy(['entityExternalId' => $entityExternalId]);
        if ($entityEntry instanceof EntityEntry) {
            throw new EntityEntryExistException();
        }
        return new EntityEntry($domainEntity, $entityExternalId, $user);
    }

    /**
     * @param EntityEntry $entityEntry
     * @return bool
     */
    public function delete(EntityEntry $entityEntry): bool
    {
        try {
            $this->getEntityManager()->remove($entityEntry);
            $this->getEntityManager()->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            throw new CanNotDeleteEntityEntryThatInUseException();
        }
        return true;
    }

}