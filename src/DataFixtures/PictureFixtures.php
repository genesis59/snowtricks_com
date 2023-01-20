<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $uploadDirectory = $this->parameterBag->get('picture_trick_fixtures_upload_directory');
        $fixturesDirectory = $this->parameterBag->get('picture_trick_fixtures_data_directory');
        $defaultPicture = $this->parameterBag->get('default_picture');
        if (is_string($uploadDirectory) && is_string($fixturesDirectory) && is_string($defaultPicture)) {
            if (is_array(glob($uploadDirectory . "*"))) {
                array_map('unlink', glob($uploadDirectory . "*"));
            }
            copy($fixturesDirectory . $defaultPicture, $uploadDirectory . $defaultPicture);
        }

        $pictureData = [
            '360-front.jpg',
            'frontside-cork-540.jpg',
            'fifty-fifty.jpg',
            'mfm-butter-180.jpg',
            'board-slide.jpg',
            'japan-air.jpg',
            'indy-grab.jpg',
            'tail-press.jpg',
            'backside-180.jpg',
            'tripod.jpg',
            'lip-slide.jpg',
            'fs-tail-slide.jpg'
        ];
        for ($i = 1; $i <= count($pictureData); $i++) {
            if (is_string($uploadDirectory) && is_string($fixturesDirectory)) {
                copy($fixturesDirectory . $pictureData[$i - 1], $uploadDirectory . $pictureData[$i - 1]);
            }
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
