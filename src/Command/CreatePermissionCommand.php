<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;
use App\Entity\DomainEntity;

class CreatePermissionCommand
{
    /**
     * @var string
     */
    private $operation;
    /**
     * @var DomainEntity
     */
    private $domainEntity;
    /**
     * @var array
     */
    private $businessRules;

    /**
     * CreatePermissionCommand constructor.
     * @param string $operation
     * @param DomainEntity $domainEntity
     * @param array $businessRules
     */
    public function __construct(string $operation, DomainEntity $domainEntity, $businessRules = [])
    {
        v::alnum('_')
            ->length(2)
            ->lowercase()
            ->noWhitespace()
            ->assert($operation);
        v::arrayType()->assert($businessRules);

        $this->operation = $operation;
        $this->domainEntity = $domainEntity;
        $this->businessRules = $businessRules;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return DomainEntity
     */
    public function getDomainEntity(): DomainEntity
    {
        return $this->domainEntity;
    }

    /**
     * @return array
     */
    public function getBusinessRules(): array
    {
        return $this->businessRules;
    }
}