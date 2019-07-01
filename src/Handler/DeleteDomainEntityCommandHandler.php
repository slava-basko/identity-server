<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\DeleteDomainEntityCommand;
use App\Repository\DomainEntityRepository;

class DeleteDomainEntityCommandHandler
{
    /**
     * @var DomainEntityRepository
     */
    private $domainEntityRepository;

    /**
     * DeleteDomainEntityCommandHandler constructor.
     * @param DomainEntityRepository $domainEntityRepository
     */
    public function __construct(
        DomainEntityRepository $domainEntityRepository
    )
    {
        $this->domainEntityRepository = $domainEntityRepository;
    }

    /**
     * @param DeleteDomainEntityCommand $command
     */
    public function handle(DeleteDomainEntityCommand $command)
    {
        $domainEntity = $this->domainEntityRepository->getDomainEntityByName($command->getName());
        $this->domainEntityRepository->delete($domainEntity);
    }
}