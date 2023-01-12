<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
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
            $user->setPassword('Testtest1.');
            $user->setIsActivated(true);
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }
}
