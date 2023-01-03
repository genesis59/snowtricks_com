<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class UserListener
{
    public function __construct(
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }
    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $user->setUuid(Uuid::v4());
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setActivationToken($this->tokenGenerator->generateToken());
        $user->setActivationTokenCreatedAt(new \DateTimeImmutable());
    }
}
