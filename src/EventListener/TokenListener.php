<?php

namespace App\EventListener;

use App\Entity\Token;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TokenListener
{
    public function __construct(
        private readonly TokenGeneratorInterface $tokenGenerator
    ) {
    }
    public function prePersist(Token $token, LifecycleEventArgs $args): void
    {
        $token->setToken($this->tokenGenerator->generateToken());
        $date = new \DateTimeImmutable();
        $token->setCreatedAt($date);
        $token->setExpiredAt($date->modify('+1 day'));
    }
}
