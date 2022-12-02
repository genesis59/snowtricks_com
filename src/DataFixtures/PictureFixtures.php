<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $pictureData = [
            '360-front.jpg',
            'frontside-cork-540.jpg',
            'fifty-fifty.jpg',
            'mfm-butter-180.jpg',
            'board-slide.jpg',
            'japan-air.jpg',
            'indy-grab.jpg'
        ];
        for ($i = 1; $i <= count($pictureData); $i++) {
            /** @var Trick $trick */
            $trick = $this->getReference('trick' . $i);
            $picture = new Picture();
            $picture->setFileName($pictureData[$i - 1]);
            $picture->setUuid(Uuid::v4());
            $picture->setIsMain(true);
            $picture->setTrick($trick);
            $manager->persist($picture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class
        ];
    }
}
