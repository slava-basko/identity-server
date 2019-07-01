<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Entity\Interfaces\PermissionInterface;
use App\Exceptions\Logic\TokenExpiredException;
use App\Utils\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Is\Sdk\Value\Answer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 * @ORM\Table(name="token")
 */
class Token
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $expire;

    /**
     * Token constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = Uuid::generate();
        $this->user = $user;

        $this->token = Uuid::generate();
        
        $expire = new \DateTime();
        $expire->add(new \DateInterval('PT2H'));
        $this->expire = $expire;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->token;
    }

    /**
     * @return \DateTime
     */
    public function getExpire(): \DateTime
    {
        return $this->expire;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user->getId();
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user->getEmail();
    }

    /**
     * @param PermissionInterface $searchedPermission
     * @return Answer
     */
    public function isTokenOwnerHasPermission(PermissionInterface $searchedPermission): Answer
    {
        $now = new \DateTime();
        if ($now > $this->expire) {
            throw new TokenExpiredException();
        }

        return $this->user->hasPermission($searchedPermission);
    }
}