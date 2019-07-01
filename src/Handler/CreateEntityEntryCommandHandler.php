<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;


use App\Command\CreateEntityEntryCommand;
use App\Repository\DomainEntityRepository;
use App\Repository\EntityEntryRepository;
use App\Repository\UserRepository;

class CreateEntityEntryCommandHandler
{
    /**
     * @var EntityEntryRepository
     */
    private $entityEntryRepository;

    /**
     * @var DomainEntityRepository
     */
    private $domainEntityRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CreateEntityEntryCommandHandler constructor.
     * @param EntityEntryRepository $entityEntryRepository
     * @param DomainEntityRepository $domainEntityRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityEntryRepository $entityEntryRepository,
        DomainEntityRepository $domainEntityRepository,
        UserRepository $userRepository
    )
    {
        $this->entityEntryRepository = $entityEntryRepository;
        $this->domainEntityRepository = $domainEntityRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateEntityEntryCommand $command
     */
    public function handle(CreateEntityEntryCommand $command)
    {
        $domainEntity = $this->domainEntityRepository->getDomainEntityByName($command->getDomainEntity());
        $user = $this->userRepository->getUserByEmail($command->getUserEmail());

        $entityEntry = $this->entityEntryRepository->createNew(
            $domainEntity,
            $command->getEntityExternalId(),
            $user
        );
        $this->entityEntryRepository->save($entityEntry);
    }
}