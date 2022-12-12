<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TokenGeneratorInterface $tokenGenerator
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // mdp: testtest faire la génération
        $userData = [
            ['bunny', 'bunny@google.com'],
            ['lion', 'lion@google.com'],
            ['bear', 'bear@google.com'],
            ['whale', 'whale@google.com'],
            ['monkey', 'monkey@google.com'],
            ['elephant', 'elephant@google.com'],
        ];
        for ($i = 1; $i <= count($userData); $i++) {
            $user = new User();
            $user->setName($userData[$i - 1][0]);
            $user->setEmail($userData[$i - 1][1]);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'Testtest1.'));
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setActivationToken($this->tokenGenerator->generateToken());
            $user->setActivationTokenCreatedAt(new \DateTimeImmutable());
            $user->setIsActivated(true);
            $user->setUuid(Uuid::v4());
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }
}
