<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Utils\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntityEntryRepository")
 * @ORM\Table(name="entity_entry")
 */
class EntityEntry
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @var string
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DomainEntity")
     * @ORM\JoinColumn(name="domain_entity_id", referencedColumnName="id")
     * @var DomainEntity
     */
    private $domainEntity;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $entityExternalId;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    /**
     * EntityEntry constructor.
     * @param DomainEntity $domainEntity
     * @param $entityExternalId
     * @param User $user
     */
    public function __construct(DomainEntity $domainEntity, $entityExternalId, User $user)
    {
        $this->id = Uuid::generate();
        $this->domainEntity = $domainEntity;
        $this->entityExternalId = $entityExternalId;
        $this->user = $user;
    }
}
