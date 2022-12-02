<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // mdp: testtest
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
            $user->setPassword(
                '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA'
            );
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUuid(Uuid::v4());
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }
}
