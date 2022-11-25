<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Photo;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Group
        $groupData = ['Grabs', 'Rotations', 'Rotations désaxés', 'Slides', 'Old school'];
        $groupList = [];
        for ($i = 1; $i <= count($groupData); $i++) {
            $group = new Group();
            $group->setUuid(Uuid::v4());
            $group->setName($groupData[$i - 1]);
            $manager->persist($group);
            $groupList[] = $group;
        }

        // User (mdp: testtest)
        $userData = [
            ['bunny', 'bunny@google.com'],
            ['lion', 'lion@google.com'],
            ['bear', 'bear@google.com'],
            ['whale', 'whale@google.com'],
            ['monkey', 'monkey@google.com'],
            ['elephant', 'elephant@google.com'],
        ];
        for ($i = 1; $i <= count($userData); $i++) {
            ${'user' . $i} = new User();
            ${'user' . $i}->setName($userData[$i - 1][0]);
            ${'user' . $i}->setEmail($userData[$i - 1][1]);
            ${'user' . $i}->setPassword(
                '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA'
            );
            ${'user' . $i}->setCreatedAt(new \DateTimeImmutable());
            ${'user' . $i}->setUuid(Uuid::v4());
            $manager->persist(${'user' . $i});
        }


        // Photo
        $photoData = ['bunny.jpg', 'lion.jpg', 'bear.jpg', 'whale.jpg', 'monkey.jpg', 'elephant.jpg'];
        for ($i = 1; $i <= count($photoData); $i++) {
            $photo = new Photo();
            $photo->setUuid(Uuid::v4());
            $photo->setName($photoData[$i - 1]);
            $photo->setUser(${'user' . $i});
            $manager->persist($photo);
        }

        // Trick
        $trickData = [
            [
                '360 front',
                '360-front',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $groupList[1]
            ],
            [
                'Frontside Cork 540',
                'frontside-cork-540',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $groupList[2]
            ],
            [
                'Fifty fifty',
                'fifty-fifty',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $groupList[3]
            ],
            [
                'MFM Butter 180',
                'mfm-butter-180',
                'Le MFM butter est un grand classique à avoir dans votre palette de tricks. Il est possible de 
                l’effectuer d’une multitude de manières, ce qui laisse libre cours à votre créativité. 
                A un niveau plus élevé, les butters peuvent être réalisés sur des modules comme des boxes, 
                en street ou encore sur le knukle des kickers. Les tricks réalisés sur les knuckles sont 
                revenus très à la mode dans le snowboard, mais au niveau du 21éme sc. La création de l’épreuve 
                “knuckle huck” des X Games témoigne de l’engouement des snowborders et du public pour ce genre 
                de tricks. Aujourd’hui, des riders charismatiques ayant une grande maitrise du MFM butter comme 
                Dylan Gamache du crew les Yawgoons, actualise sans cesse ce tricks. Dans une version plus mainstream, 
                on retrouve des snowboarders comme Marcus Kleveland qui contribue au renouveau de la pratique du 
                buttering, grâce à des performances exceptionnelles et à une grosse présence sur les réseaux sociaux.',
                $groupList[2]
            ],
            [
                'Board slide',
                'board-slide',
                'Le boardslide (prononcez à l\'anglaise, "bort\'slaïde") est un trick de skateboard. Il fait partie
                 de la catégorie des slides et s\'effectue par conséquent sur la partie en bois du skateboard. Un 
                 boardslide consiste à faire passer l\'essieu avant du skateboard au-dessus d\'un obstacle pour faire 
                 glisser la partie centrale. Ce tricks va de pair avec le lipslide, qui consiste à faire passer 
                 l\'essieu arrière par-dessus l\'obstacle (variante beaucoup plus difficile).Il est aussi possible 
                 de faire un boardslide en slappy, ce qui signifie « sans faire de ollie ». Pour cela, il faut un 
                 rail qui ne soit pas trop haut, ou même qui touche le sol puis monte progressivement. Ainsi, il 
                 suffit de rouler, de lever les roues avant et les passer par-dessus la barre, de manière à se 
                 positionner en boardslide.Un darkslide est un boardslide fait avec le skate à l\'envers.',
                $groupList[3]
            ],
            [
                'Japan Air',
                'japan-air',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $groupList[4]
            ],
            [
                'Indy Grab',
                'indy-grab',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $groupList[0]
            ],
            [
                '360 front 2',
                '360-front-2',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $groupList[1]
            ],
            [
                'Frontside Cork 540 2',
                'frontside-cork-540-2',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $groupList[2]
            ],
            [
                'Fifty fifty2',
                'fifty-fifty2',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $groupList[3]
            ],
            [
                'MFM Butter 180 2',
                'mfm-butter-180-2',
                'Le MFM butter est un grand classique à avoir dans votre palette de tricks. Il est possible de 
                l’effectuer d’une multitude de manières, ce qui laisse libre cours à votre créativité. 
                A un niveau plus élevé, les butters peuvent être réalisés sur des modules comme des boxes, 
                en street ou encore sur le knukle des kickers. Les tricks réalisés sur les knuckles sont 
                revenus très à la mode dans le snowboard, mais au niveau du 21éme sc. La création de l’épreuve 
                “knuckle huck” des X Games témoigne de l’engouement des snowborders et du public pour ce genre 
                de tricks. Aujourd’hui, des riders charismatiques ayant une grande maitrise du MFM butter comme 
                Dylan Gamache du crew les Yawgoons, actualise sans cesse ce tricks. Dans une version plus mainstream, 
                on retrouve des snowboarders comme Marcus Kleveland qui contribue au renouveau de la pratique du 
                buttering, grâce à des performances exceptionnelles et à une grosse présence sur les réseaux sociaux.',
                $groupList[2]
            ],
            [
                'Board slide2',
                'board-slide2',
                'Le boardslide (prononcez à l\'anglaise, "bort\'slaïde") est un trick de skateboard. Il fait partie
                 de la catégorie des slides et s\'effectue par conséquent sur la partie en bois du skateboard. Un 
                 boardslide consiste à faire passer l\'essieu avant du skateboard au-dessus d\'un obstacle pour faire 
                 glisser la partie centrale. Ce tricks va de pair avec le lipslide, qui consiste à faire passer 
                 l\'essieu arrière par-dessus l\'obstacle (variante beaucoup plus difficile).Il est aussi possible 
                 de faire un boardslide en slappy, ce qui signifie « sans faire de ollie ». Pour cela, il faut un 
                 rail qui ne soit pas trop haut, ou même qui touche le sol puis monte progressivement. Ainsi, il 
                 suffit de rouler, de lever les roues avant et les passer par-dessus la barre, de manière à se 
                 positionner en boardslide.Un darkslide est un boardslide fait avec le skate à l\'envers.',
                $groupList[3]
            ],
            [
                'Japan Air2',
                'japan-air2',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $groupList[4]
            ],
            [
                'Indy Grab2',
                'indy-grab2',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $groupList[0]
            ],
            [
                '360 front 3',
                '360-front-3',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $groupList[1]
            ],
            [
                'Frontside Cork 540 3',
                'frontside-cork-540-3',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $groupList[2]
            ],
            [
                'Fifty fifty3',
                'fifty-fifty3',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $groupList[3]
            ],
            [
                'MFM Butter 180 3',
                'mfm-butter-180-3',
                'Le MFM butter est un grand classique à avoir dans votre palette de tricks. Il est possible de 
                l’effectuer d’une multitude de manières, ce qui laisse libre cours à votre créativité. 
                A un niveau plus élevé, les butters peuvent être réalisés sur des modules comme des boxes, 
                en street ou encore sur le knukle des kickers. Les tricks réalisés sur les knuckles sont 
                revenus très à la mode dans le snowboard, mais au niveau du 21éme sc. La création de l’épreuve 
                “knuckle huck” des X Games témoigne de l’engouement des snowborders et du public pour ce genre 
                de tricks. Aujourd’hui, des riders charismatiques ayant une grande maitrise du MFM butter comme 
                Dylan Gamache du crew les Yawgoons, actualise sans cesse ce tricks. Dans une version plus mainstream, 
                on retrouve des snowboarders comme Marcus Kleveland qui contribue au renouveau de la pratique du 
                buttering, grâce à des performances exceptionnelles et à une grosse présence sur les réseaux sociaux.',
                $groupList[2]
            ],
            [
                'Board slide3',
                'board-slide3',
                'Le boardslide (prononcez à l\'anglaise, "bort\'slaïde") est un trick de skateboard. Il fait partie
                 de la catégorie des slides et s\'effectue par conséquent sur la partie en bois du skateboard. Un 
                 boardslide consiste à faire passer l\'essieu avant du skateboard au-dessus d\'un obstacle pour faire 
                 glisser la partie centrale. Ce tricks va de pair avec le lipslide, qui consiste à faire passer 
                 l\'essieu arrière par-dessus l\'obstacle (variante beaucoup plus difficile).Il est aussi possible 
                 de faire un boardslide en slappy, ce qui signifie « sans faire de ollie ». Pour cela, il faut un 
                 rail qui ne soit pas trop haut, ou même qui touche le sol puis monte progressivement. Ainsi, il 
                 suffit de rouler, de lever les roues avant et les passer par-dessus la barre, de manière à se 
                 positionner en boardslide.Un darkslide est un boardslide fait avec le skate à l\'envers.',
                $groupList[3]
            ],
            [
                'Japan Air3',
                'japan-air3',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $groupList[4]
            ],
            [
                'Indy Grab3',
                'indy-grab3',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $groupList[0]
            ]
        ];
        for ($i = 1; $i <= count($trickData); $i++) {
            ${'trick' . $i} = new Trick();
            ${'trick' . $i}->setName($trickData[$i - 1][0]);
            ${'trick' . $i}->setSlug($trickData[$i - 1][1]);
            ${'trick' . $i}->setDescription($trickData[$i - 1][2]);
            ${'trick' . $i}->setCreatedAt(new \DateTimeImmutable());
            ${'trick' . $i}->setTrickGroup($trickData[$i - 1][3]);
            ${'trick' . $i}->setUser($user1);
            $manager->persist(${'trick' . $i});
        }

        // Video
        $videoData = [
            'https://www.youtube.com/embed/JJy39dO_PPE',
            'https://www.youtube.com/embed/FMHiSF0rHF8',
            'https://www.youtube.com/embed/n9ifYkF-ghw',
            'https://www.youtube.com/embed/LyfFuv4_wjQ',
            'https://www.youtube.com/embed/12OHPNTeoRs',
            'https://www.youtube.com/embed/CzDjM7h_Fwo',
            'https://www.youtube.com/embed/iKkhKekZNQ8',
            'https://www.youtube.com/embed/JJy39dO_PPE',
            'https://www.youtube.com/embed/FMHiSF0rHF8',
            'https://www.youtube.com/embed/n9ifYkF-ghw',
            'https://www.youtube.com/embed/LyfFuv4_wjQ',
            'https://www.youtube.com/embed/12OHPNTeoRs',
            'https://www.youtube.com/embed/CzDjM7h_Fwo',
            'https://www.youtube.com/embed/iKkhKekZNQ8'
        ];
        for ($i = 1; $i <= count($videoData); $i++) {
            $video = new Video();
            $video->setUuid(Uuid::v4());
            $video->setSource($videoData[$i - 1]);
            $video->setTrick(${'trick' . $i});
            $manager->persist($video);
        }
        // Picture
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
            $picture = new Picture();
            $picture->setFileName($pictureData[$i - 1]);
            $picture->setUuid(Uuid::v4());
            $picture->setIsMain(true);
            $picture->setTrick(${'trick' . $i});
            $manager->persist($picture);
        }
        // Comment

        $manager->flush();
    }
}
