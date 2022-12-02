<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Group $group0 */
        $group0 = $this->getReference('group0');
        /** @var Group $group1 */
        $group1 = $this->getReference('group1');
        /** @var Group $group2 */
        $group2 = $this->getReference('group2');
        /** @var Group $group3 */
        $group3 = $this->getReference('group3');
        /** @var Group $group4 */
        $group4 = $this->getReference('group4');

        $trickData = [
            [
                '360 front',
                '360-front',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $group1
            ],
            [
                'Frontside Cork 540',
                'frontside-cork-540',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $group2
            ],
            [
                'Fifty fifty',
                'fifty-fifty',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $group3
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
                $group2
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
                $group3
            ],
            [
                'Japan Air',
                'japan-air',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $group4
            ],
            [
                'Indy Grab',
                'indy-grab',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $group0
            ],
            [
                '360 front 2',
                '360-front-2',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $group1
            ],
            [
                'Frontside Cork 540 2',
                'frontside-cork-540-2',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $group2
            ],
            [
                'Fifty fifty2',
                'fifty-fifty2',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $group3
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
                $group2
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
                $group3
            ],
            [
                'Japan Air2',
                'japan-air2',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $group4
            ],
            [
                'Indy Grab2',
                'indy-grab2',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $group0
            ],
            [
                '360 front 3',
                '360-front-3',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $group1
            ],
            [
                'Frontside Cork 540 3',
                'frontside-cork-540-3',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $group2
            ],
            [
                'Fifty fifty3',
                'fifty-fifty3',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $group3
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
                $group2
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
                $group3
            ],
            [
                'Japan Air3',
                'japan-air3',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $group4
            ],
            [
                'Indy Grab3',
                'indy-grab3',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $group0
            ]
        ];
        for ($i = 1; $i <= count($trickData); $i++) {
            /** @var User $user */
            $user = $this->getReference('user1');
            $trick = new Trick();
            $trick->setName($trickData[$i - 1][0]);
            $trick->setSlug($trickData[$i - 1][1]);
            $trick->setDescription($trickData[$i - 1][2]);
            $trick->setCreatedAt(new \DateTimeImmutable());
            $trick->setTrickGroup($trickData[$i - 1][3]);
            $trick->setUser($user);
            $this->addReference('trick' . $i, $trick);
            $manager->persist($trick);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GroupFixtures::class,
            UserFixtures::class
        ];
    }
}
