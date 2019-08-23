<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Entity\Interfaces\PermissionInterface;
use App\Exceptions\Logic\TokenExpiredException;
use App\Utils\Uuid;
use App\Value\User\AdditionalData;
use Doctrine\ORM\Mapping as ORM;
use Is\Sdk\Value\Answer;
use \App\Utils\Env;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
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
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $ip = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $userAgent = null;

    /**
     * Token constructor.
     * @param User $user
     * @param object|null $additionalData
     * @throws \Exception
     */
    public function __construct(User $user, $additionalData)
    {
        $token_expiration_time = Env::get('TOKEN_EXPIRATION_TIME');
        $expire = new \DateTime();
        $expire->add(new \DateInterval($token_expiration_time));
        $this->expire = $expire;

        $this->id = Uuid::generate();
        $this->user = $user;
        $this->token = Uuid::generate();
        if($additionalData){
            $this->userAgent = $additionalData->getUserAgent();
            $this->ip = $additionalData->getIp();
        }

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
     * @return bool
     * @throws \Exception
     */
    public function isExpired()
    {
        $now = new \DateTime();
        if ($now > $this->expire) {
            return true;
        }
        return false;
    }

    /**
     * @param PermissionInterface $searchedPermission
     * @return Answer
     */
    public function isTokenOwnerHasPermission(PermissionInterface $searchedPermission): Answer
    {
        if ($this->isExpired()) {
            throw new TokenExpiredException();
        }

        return $this->user->hasPermission($searchedPermission);
    }

}