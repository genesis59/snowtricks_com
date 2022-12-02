<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $photoData = ['bunny.jpg', 'lion.jpg', 'bear.jpg', 'whale.jpg', 'monkey.jpg', 'elephant.jpg'];
        for ($i = 1; $i <= count($photoData); $i++) {
            /** @var User $user */
            $user = $this->getReference('user' . $i);
            $photo = new Photo();
            $photo->setUuid(Uuid::v4());
            $photo->setName($photoData[$i - 1]);
            $photo->setUser($user);
            $manager->persist($photo);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
