<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Uid\Uuid;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $uploadDirectory = $this->parameterBag->get('photo_user_fixtures_upload_directory');
        $fixturesDirectory = $this->parameterBag->get('photo_user_fixtures_data_directory');
        if (is_string($uploadDirectory) && is_string($fixturesDirectory)) {
            if (is_array(glob($uploadDirectory . "*"))) {
                array_map('unlink', glob($uploadDirectory . "*"));
            }
        }
        $photoData = ['bunny.jpg', 'lion.jpg', 'bear.jpg', 'whale.jpg', 'monkey.jpg', 'elephant.jpg'];
        for ($i = 1; $i <= count($photoData); $i++) {
            if (is_string($uploadDirectory) && is_string($fixturesDirectory)) {
                copy($fixturesDirectory . $photoData[$i - 1], $uploadDirectory . $photoData[$i - 1]);
            }
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
