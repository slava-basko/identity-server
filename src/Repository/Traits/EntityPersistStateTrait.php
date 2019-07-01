<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository\Traits;

trait EntityPersistStateTrait
{
    /**
     * Flush changes
     */
    public function flush() : void
    {
        /**
         * @var $this \Doctrine\ORM\EntityRepository
         */
        $this->getEntityManager()->flush();
        return;
    }

    /**
     * @param $entity
     */
    public function persist($entity) : void
    {
        /**
         * @var $this \Doctrine\ORM\EntityRepository
         */
        $this->getEntityManager()->persist($entity);
        return;
    }

    /**
     * Persist and flush
     *
     * @param $entity
     */
    public function save($entity) : void
    {
        $this->persist($entity);
        $this->flush();
        return;
    }
}