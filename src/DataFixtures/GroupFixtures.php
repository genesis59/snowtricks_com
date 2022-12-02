<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $groupData = ['Grabs', 'Rotations', 'Rotations désaxés', 'Slides', 'Old school'];
        for ($i = 0; $i < count($groupData); $i++) {
            $group = new Group();
            $group->setUuid(Uuid::v4());
            $group->setName($groupData[$i]);
            $manager->persist($group);
            $this->addReference('group' . $i, $group);
        }
        $manager->flush();
    }
}
