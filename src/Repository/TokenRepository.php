<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\Token;
use App\Entity\User;
use App\Exceptions\Logic\TokenExistException;
use App\Exceptions\Logic\TokenNotExistException;
use App\Repository\Traits\EntityPersistStateTrait;
use Doctrine\ORM\EntityRepository;

class TokenRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param User $user
     * @return Token
     */
    public function createNewFor(User $user): Token
    {
        $token = $this->findOneBy(['user' => $user->getId()]);
        if ($token instanceof Token) {
            throw new TokenExistException();
        }

        return new Token($user);
    }

    /**
     * @param string $token
     * @return Token
     */
    public function getToken(string $token): Token
    {
        $token = $this->findOneBy(['token' => $token]);
        if (!($token instanceof Token)) {
            throw new TokenNotExistException();
        }
        /**
         * @var Token $token
         */
        return $token;
    }

    /**
     * @param string $userId
     * @return Token
     */
    public function getTokenByUserId(string $userId): Token
    {
        $token = $this->findOneBy(['user' => $userId]);
        if (!($token instanceof Token)) {
            throw new TokenNotExistException();
        }
        /**
         * @var Token $token
         */
        return $token;
    }
}