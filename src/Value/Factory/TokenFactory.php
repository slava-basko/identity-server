<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Value\Factory;

use Is\Sdk\Auth\Token;
use Is\Sdk\Auth\User;

class TokenFactory
{
    /**
     * @param \App\Entity\Token $token
     * @return Token
     */
    public static function valueObjectFromEntity(\App\Entity\Token $token): Token
    {
        return new Token(
            new User($token->getUserId(), $token->getUserEmail()),
            (string)$token,
            $token->getExpire()
        );
    }
}