<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Entity\Interfaces\PermissionInterface;
use App\Exceptions\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use App\Utils\Uuid;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PermissionRepository")
 * @ORM\Table(name="permissions")
 */
class Permission implements PermissionInterface
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @var string
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $operation;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DomainEntity")
     * @ORM\JoinColumn(name="domain_entity_id", referencedColumnName="id")
     * @var DomainEntity
     */
    private $domainEntity;
    
    /**
     * @ORM\Column(type="simple_array", nullable=true)
     * @var string[]
     */
    private $businessRules;

    /**
     * Permission constructor.
     * @param string $operation
     * @param DomainEntity $domainEntity
     * @param string[] $businessRules
     */
    public function __construct(string $operation, DomainEntity $domainEntity, $businessRules = [])
    {
        foreach ($businessRules as $bizRule) {
            if (!(is_string($bizRule))) {
                throw new InvalidArgumentException('Invalid business rule.');
            }
        }

        $this->id = Uuid::hash($operation.$domainEntity);
        $this->operation = $operation;
        $this->domainEntity = $domainEntity;
        $this->businessRules = $businessRules;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function isEqualTo(PermissionInterface $permission): bool
    {
        return ($this->id == $permission->getId());
    }

    /**
     * @return string[]
     */
    public function getBusinessRules(): array
    {
        return $this->businessRules;
    }
}
