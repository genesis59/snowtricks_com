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
            $trick->setCreatedAt(new \DateTimeImmutable());
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
                frontside consiste ?? quitter la pente et ?? effectuer une rotation de 360 degr??s dans les airs avant de 
                toucher ?? nouveau le sol.',
                $groups['group1']
            ],
            [
                'Frontside Cork 540',
                'Le frontside Cork 540 est l\'une des meilleures figures de snowboard. Cette combinaison de flip et de 
                spin est facile ?? regarder, et ??tonnamment facile en g??n??ral une fois que l\'on s\'y est habitu??.',
                $groups['group2']

            ],
            [
                'Fifty fifty',
                'Le 50 50 ou fifty fifty est le premier slide ?? essayer. Si vous ??tes d??butant et que vous souhaitez 
                apprendre ?? slider en snowboard, regarder les tutoriels vid??os de Nomad Snowboard.',
                $groups['group3']

            ],
            [
                'MFM Butter 180',
                'Le MFM butter est un grand classique ?? avoir dans votre palette de tricks. Il est possible de 
                l???effectuer d???une multitude de mani??res, ce qui laisse libre cours ?? votre cr??ativit??. 
                A un niveau plus ??lev??, les butters peuvent ??tre r??alis??s sur des modules comme des boxes, 
                en street ou encore sur le knukle des kickers. Les tricks r??alis??s sur les knuckles sont 
                revenus tr??s ?? la mode dans le snowboard, mais au niveau du 21??me sc. La cr??ation de l?????preuve 
                ???knuckle huck??? des X Games t??moigne de l???engouement des snowborders et du public pour ce genre 
                de tricks. Aujourd???hui, des riders charismatiques ayant une grande maitrise du MFM butter comme 
                Dylan Gamache du crew les Yawgoons, actualise sans cesse ce tricks. Dans une version plus mainstream, 
                on retrouve des snowboarders comme Marcus Kleveland qui contribue au renouveau de la pratique du 
                buttering, gr??ce ?? des performances exceptionnelles et ?? une grosse pr??sence sur les r??seaux sociaux.',
                $groups['group2']

            ],
            [
                'Board slide',
                'Le boardslide (prononcez ?? l\'anglaise, "bort\'sla??de") est un trick de skateboard. Il fait partie
                 de la cat??gorie des slides et s\'effectue par cons??quent sur la partie en bois du skateboard. Un 
                 boardslide consiste ?? faire passer l\'essieu avant du skateboard au-dessus d\'un obstacle pour faire 
                 glisser la partie centrale. Ce tricks va de pair avec le lipslide, qui consiste ?? faire passer 
                 l\'essieu arri??re par-dessus l\'obstacle (variante beaucoup plus difficile).Il est aussi possible 
                 de faire un boardslide en slappy, ce qui signifie ?? sans faire de ollie ??. Pour cela, il faut un 
                 rail qui ne soit pas trop haut, ou m??me qui touche le sol puis monte progressivement. Ainsi, il 
                 suffit de rouler, de lever les roues avant et les passer par-dessus la barre, de mani??re ?? se 
                 positionner en boardslide.Un darkslide est un boardslide fait avec le skate ?? l\'envers.',
                $groups['group3']

            ],
            [
                'Japan Air',
                'Un Japan est essentiellement une prise muette que vous tweakez derri??re votre dos ! Un bon tweaked 
                Japan est tr??s divertissant ?? regarder et encore plus amusant ?? pi??tiner. Ajouter des Japan grabs 
                ?? vos tricks est un moyen s??r d\'obtenir des props de vos amis.',
                $groups['group4']

            ],
            [
                'Indy Grab',
                'Un indy grab, g??n??ralement appel?? simplement indy, est un trick de skateboard. C\'est un trick a??rien 
                de la cat??gorie des grabs durant lequel le skateur saisit le milieu de sa planche, entre ses deux 
                pieds, sur le c??t?? o?? pointent ses orteils. L\'indy est effectu?? depuis les ann??es \'70.',
                $groups['group0']

            ],
            [
                'Tail press',
                'Vous commencez tout juste ?? vous sentir ?? l\'aise dans le parc et vous r??ussissez ?? faire des 50-50 
                sur des caract??ristiques XS et/ou S. Quelle est la prochaine ??tape ? Le Tail Press est le deuxi??me 
                trick de jib le plus facile ?? apprendre, et un moyen rapide d\'ajouter du style ?? votre riding.
                Apprendre le Tail Press sur un jib est exactement la m??me position corporelle que 
                d\'apprendre ?? butter sur la queue de votre snowboard.',
                $groups['group0']

            ],
            [
                'Backside 180',
                'le backside 180. Nous commen??ons par les m??canismes de base du trick et nous progressons pour 
                ??tre capable de faire un backside 180 depuis le sol plat. J\'esp??re que vous appr??cierez cette vid??o !',
                $groups['group1']

            ],
            [
                'Tripod',
                'La planche est verticale et le nez est appuy?? sur le sol avec les deux mains plant??es sur le sol, 
                le rider fait face ?? la mont??e. Je vais poster une vid??o et un tutoriel si vous le souhaitez.',
                $groups['group0']

            ],
            [
                'Lip slide',
                'Les Lipslides ressemblent beaucoup aux Boardslides avec la diff??rence que vous soulevez votre truck 
                arri??re au lieu de votre truck avant sur l\'obstacle. C\'est une bonne base pour avoir des FS 
                tailslides verrouill??s d??j?? parce que le mouvement est similaire.',
                $groups['group3']

            ],
            [
                'FS tailslides 270',
                'Un frontside tailslide (ou FS tailslide) est un slide sur la queue de la planche de skateboard. 
                Pour effectuer un frontside tailslide, vous faites un ollie et atterrissez avec la queue de la 
                planche sur le bord de la l??vre d\'un obstacle. Vous pouvez r??aliser cette figure de skateboard 
                sur presque tous les obstacles, y compris les curbs, les ledges, les transitions et les rails.',
                $groups['group3']
            ]
        ];
    }
}
