<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Handler;

use App\Command\CreateDomainEntityCommand;
use App\Repository\DomainEntityRepository;

class CreateDomainEntityCommandHandler
{
    /**
     * @var DomainEntityRepository
     */
    private $repository;

    /**
     * CreateDomainEntityCommandHandler constructor.
     * @param DomainEntityRepository $repository
     */
    public function __construct(
        DomainEntityRepository $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateDomainEntityCommand $command
     */
    public function handle(CreateDomainEntityCommand $command)
    {
        $role = $this->repository->createNew($command->getName());
        $this->repository->save($role);
    }
}
