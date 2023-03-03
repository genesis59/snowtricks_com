<?php

namespace App\EventListener;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserListener
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TokenRepository $tokenRepository
    ) {
    }
    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $token = new Token();
        $this->tokenRepository->save($token, true);
        $user->setUuid(Uuid::v4());
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setActivationToken($token);
    }
}
