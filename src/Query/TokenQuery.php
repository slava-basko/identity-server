<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Query;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;

class TokenQuery
{
    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    /**
     * TokenQuery constructor.
     * @param TokenRepository $tokenRepository
     */
    public function __construct(
        TokenRepository $tokenRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param User $user
     * @return Token
     */
    public function getUserToken(User $user): Token
    {
        return $this->tokenRepository->getTokenByUserId($user->getId());
    }

    /**
     * @param string $token
     * @return Token
     */
    public function getToken(string $token): Token
    {
        return $this->tokenRepository->getToken($token);
    }
}