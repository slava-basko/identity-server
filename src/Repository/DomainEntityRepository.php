<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\DomainEntity;
use App\Exceptions\Logic\CanNotDeleteDomainEntityThatInUseException;
use App\Exceptions\Logic\DomainEntityExistException;
use App\Repository\Traits\EntityPersistStateTrait;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class DomainEntityRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param string $name
     * @return DomainEntity
     */
    public function createNew(string $name): DomainEntity
    {
        $domainEntity = $this->findOneBy(['name' => $name]);
        if ($domainEntity instanceof DomainEntity) {
            throw new DomainEntityExistException();
        }
        return new DomainEntity($name);
    }

    /**
     * @param DomainEntity $domainEntity
     * @return bool
     */
    public function delete(DomainEntity $domainEntity): bool
    {
        try {
            $this->getEntityManager()->remove($domainEntity);
            $this->getEntityManager()->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            throw new CanNotDeleteDomainEntityThatInUseException();
        }
        return true;
    }

    /**
     * @param string $name
     * @return DomainEntity
     * @throws EntityNotFoundException
     */
    public function getDomainEntityByName(string $name): DomainEntity
    {
        $domainEntity = $this->findOneBy(['name' => $name]);
        if (!($domainEntity instanceof DomainEntity)) {
            throw new EntityNotFoundException();
        }

        return $domainEntity;
    }

    /**
     * @return \Generator
     */
    public function getPlainEntityList(): \Generator
    {
        $domainEntities = $this->createQueryBuilder('de')
            ->select('de.name')
            ->getQuery()
            ->getArrayResult();
        foreach ($domainEntities as $domainEntity) {
            yield $domainEntity['name'];
        }
    }
}