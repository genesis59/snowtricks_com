<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $videoData = [
            'https://www.youtube.com/embed/JJy39dO_PPE',
            'https://www.youtube.com/embed/FMHiSF0rHF8',
            'https://www.youtube.com/embed/n9ifYkF-ghw',
            'https://www.youtube.com/embed/LyfFuv4_wjQ',
            'https://www.youtube.com/embed/12OHPNTeoRs',
            'https://www.youtube.com/embed/CzDjM7h_Fwo',
            'https://www.youtube.com/embed/iKkhKekZNQ8',
            'https://www.youtube.com/embed/Kv0Ah4Xd8d0',
            'https://www.youtube.com/embed/6sNCGEibkWg',
            'https://www.youtube.com/embed/88GJqNWZ5kY',
            'https://www.youtube.com/embed/LhVuEXIT8gc',
            'https://www.youtube.com/embed/HRNXjMBakwM'
        ];
        for ($i = 1; $i <= count($videoData); $i++) {
            /** @var Trick $trick */
            $trick = $this->getReference('trick' . $i);
            $video = new Video();
            $video->setSource($videoData[$i - 1]);
            $video->setTrick($trick);
            $manager->persist($video);
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
