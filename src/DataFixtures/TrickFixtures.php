<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        /** @var array<string,Group> $groups */
        $groups = [
            'group0' => $this->getReference('group0'),
            'group1' => $this->getReference('group1'),
            'group2' => $this->getReference('group2'),
            'group3' => $this->getReference('group3'),
            'group4' => $this->getReference('group4'),
        ];
        $trickData = $this->getTricksData($groups);

        for ($i = 1; $i <= count($trickData); $i++) {
            /** @var User $user */
            $user = $this->getReference('user1');
            $trick = new Trick();
            $trick->setName($trickData[$i - 1][0]);
            $trick->setSlug($this->slugger->slug($trickData[$i - 1][0]));
            $trick->setDescription($trickData[$i - 1][1]);
            $trick->setCreatedAt((new \DateTimeImmutable())->modify('-' . $i . ' day'));
            $trick->setTrickGroup($trickData[$i - 1][2]);
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

    /**
     * @param Group[] $groups
     * @return array<array<mixed>>
     */
    private function getTricksData(array $groups): array
    {
        return [
            [
                '360 front',
                'Si vous aimez le snowboard, vous avez sans doute envie d\'apprendre des figures et des sauts ! Un 360 
                frontside consiste à quitter la pente et à effectuer une rotation de 360 degrés dans les airs avant de 
                toucher à nouveau le sol.',
                $groups['group1']
            ],
            [
                'Frontside Cork 540',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile à regarder, et étonnamment facile en général une fois que l\'on s\'y est habitué.',
                $groups['group2']

            ],
            [
                'Fifty fifty',
                'Le 50 50 ou fifty fifty est le premier slide à essayer. Si vous êtes débutant et que vous souhaitez 
                apprendre à slider en snowboard, regarder les tutoriels vidéos de Nomad Snowboard.',
                $groups['group3']

            ],
            [
                'MFM Butter 180',
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
                $groups['group2']

            ],
            [
                'Board slide',
                'Le boardslide (prononcez à l\'anglaise, "bort\'slaïde") est un trick de skateboard. Il fait partie
                 de la catégorie des slides et s\'effectue par conséquent sur la partie en bois du skateboard. Un 
                 boardslide consiste à faire passer l\'essieu avant du skateboard au-dessus d\'un obstacle pour faire 
                 glisser la partie centrale. Ce tricks va de pair avec le lipslide, qui consiste à faire passer 
                 l\'essieu arrière par-dessus l\'obstacle (variante beaucoup plus difficile).Il est aussi possible 
                 de faire un boardslide en slappy, ce qui signifie « sans faire de ollie ». Pour cela, il faut un 
                 rail qui ne soit pas trop haut, ou même qui touche le sol puis monte progressivement. Ainsi, il 
                 suffit de rouler, de lever les roues avant et les passer par-dessus la barre, de manière à se 
                 positionner en boardslide.Un darkslide est un boardslide fait avec le skate à l\'envers.',
                $groups['group3']

            ],
            [
                'Japan Air',
                'Un Japan est essentiellement une prise muette que vous tweakez derrière votre dos ! Un bon tweaked 
                Japan est très divertissant à regarder et encore plus amusant à piétiner. Ajouter des Japan grabs 
                à vos tricks est un moyen sûr d\'obtenir des props de vos amis.',
                $groups['group4']

            ],
            [
                'Indy Grab',
                'Un indy grab, généralement appelé simplement indy, est un trick de skateboard. C\'est un trick aérien 
                de la catégorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le côté où pointent ses orteils. L\'indy est effectué depuis les années \'70.',
                $groups['group0']

            ],
            [
                'Tail press',
                'Vous commencez tout juste à vous sentir à l\'aise dans le parc et vous réussissez à faire des 50-50 
                sur des caractéristiques XS et/ou S. Quelle est la prochaine étape ? Le Tail Press est le deuxième 
                trick de jib le plus facile à apprendre, et un moyen rapide d\'ajouter du style à votre riding.
                Apprendre le Tail Press sur un jib est exactement la même position corporelle que 
                d\'apprendre à butter sur la queue de votre snowboard.',
                $groups['group0']

            ],
            [
                'Backside 180',
                'le backside 180. Nous commençons par les mécanismes de base du trick et nous progressons pour 
                être capable de faire un backside 180 depuis le sol plat. J\'espère que vous apprécierez cette vidéo !',
                $groups['group1']

            ],
            [
                'Tripod',
                'La planche est verticale et le nez est appuyé sur le sol avec les deux mains plantées sur le sol, 
                le rider fait face à la montée. Je vais poster une vidéo et un tutoriel si vous le souhaitez.',
                $groups['group0']

            ],
            [
                'Lip slide',
                'Les Lipslides ressemblent beaucoup aux Boardslides avec la différence que vous soulevez votre truck 
                arrière au lieu de votre truck avant sur l\'obstacle. C\'est une bonne base pour avoir des FS 
                tailslides verrouillés déjà parce que le mouvement est similaire.',
                $groups['group3']

            ],
            [
                'FS tailslides 270',
                'Un frontside tailslide (ou FS tailslide) est un slide sur la queue de la planche de skateboard. 
                Pour effectuer un frontside tailslide, vous faites un ollie et atterrissez avec la queue de la 
                planche sur le bord de la lèvre d\'un obstacle. Vous pouvez réaliser cette figure de skateboard 
                sur presque tous les obstacles, y compris les curbs, les ledges, les transitions et les rails.',
                $groups['group3']
            ]
        ];
    }
}
