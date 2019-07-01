<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\RpcService;

use App\Command\CreateDomainEntityCommand;
use App\Command\DeleteDomainEntityCommand;
use App\Query\DomainEntityQuery;
use Is\Sdk\Service\Interfaces\DomainEntityService;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

class DomainEntityProcedure implements DomainEntityService
{
    /**
     * @var MessageBusSupportingMiddleware
     */
    private $commandBus;
    /**
     * @var DomainEntityQuery
     */
    private $domainEntityQuery;

    /**
     * User constructor.
     * @param MessageBusSupportingMiddleware $commandBus
     * @param DomainEntityQuery $domainEntityQuery
     */
    public function __construct(
        MessageBusSupportingMiddleware $commandBus,
        DomainEntityQuery $domainEntityQuery
    )
    {
        $this->commandBus = $commandBus;
        $this->domainEntityQuery = $domainEntityQuery;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function create($name)
    {
        $command = new CreateDomainEntityCommand($name);
        $this->commandBus->handle($command);
        return true;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->domainEntityQuery->getList();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete($name)
    {
        $command = new DeleteDomainEntityCommand($name);
        $this->commandBus->handle($command);
        return true;
    }
}