<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Utils\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DomainEntityRepository")
 * @ORM\Table(name="domain_entity")
 */
class DomainEntity
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="domain", unique=true)
     * @var string
     */
    private $name;

    /**
     * Domain constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Domain entity name can not be empty.');
        }

        $this->id = Uuid::generate();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
