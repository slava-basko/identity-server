<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Command;

use Respect\Validation\Validator as v;

class CreateEntityEntryCommand
{
    /**
     * @var string
     */
    private $domainEntity;

    /**
     * @var string
     */
    private $entityExternalId;

    /**
     * @var string
     */
    private $userEmail;

    /**
     * CreateEntityEntryCommand constructor.
     * @param string $domainEntity
     * @param string $entityExternalId
     * @param string $userEmail
     */
    public function __construct(string $domainEntity, string $entityExternalId, string $userEmail)
    {
        v::alnum('-')
            ->length(2)
            ->lowercase()
            ->noWhitespace()
            ->assert($entityExternalId);
        v::email()->assert($userEmail);

        $this->domainEntity = $domainEntity;
        $this->entityExternalId = $entityExternalId;
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getDomainEntity(): string
    {
        return $this->domainEntity;
    }

    /**
     * @return string
     */
    public function getEntityExternalId(): string
    {
        return $this->entityExternalId;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}