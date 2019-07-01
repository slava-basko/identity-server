<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Query;

use App\Repository\DomainEntityRepository;

class DomainEntityQuery
{
    /**
     * @var DomainEntityRepository
     */
    private $domainEntityRepository;

    /**
     * DomainEntityQuery constructor.
     * @param DomainEntityRepository $domainEntityRepository
     */
    public function __construct(
        DomainEntityRepository $domainEntityRepository
    )
    {
        $this->domainEntityRepository = $domainEntityRepository;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return iterator_to_array($this->domainEntityRepository->getPlainEntityList());
    }
}