<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Value;

use App\Entity\Interfaces\PermissionInterface;
use App\Utils\Uuid;

class SearchedPermission implements PermissionInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * SearchedPermission constructor.
     * @param string $operation
     * @param string $domainEntity
     */
    public function __construct(string $operation, string $domainEntity)
    {
        $this->id = Uuid::hash($operation.$domainEntity);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getBusinessRules(): array
    {
        return [];
    }
}