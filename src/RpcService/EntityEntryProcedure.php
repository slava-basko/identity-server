<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\CreateEntityEntryCommand;
use Is\Sdk\Service\Interfaces\EntityEntryService;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class EntityEntryProcedure implements EntityEntryService
{
    /**
     * @var MessageBusSupportingMiddleware
     */
    private $commandBus;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus
    )
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $domainEntity
     * @param $entityExternalId
     * @param $userEmail
     * @return bool
     */
    public function create($domainEntity, $entityExternalId, $userEmail)
    {
        $command = new CreateEntityEntryCommand($domainEntity, $entityExternalId, $userEmail);
        $this->commandBus->handle($command);

        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete($name)
    {
        // TODO: Implement delete() method.
    }
}