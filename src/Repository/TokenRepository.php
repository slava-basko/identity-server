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
     * @param object|null $additionalData
     * @return Token
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createNewFor(User $user,$additionalData): Token
    {
        $token = $this->findOneBy(['user' => $user->getId()]);

        if ($token instanceof Token && $token->isExpired()) {
            $em = $this->getEntityManager();
            $em->remove($token);
            $em->flush();
        }
        return new Token($user, $additionalData);
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