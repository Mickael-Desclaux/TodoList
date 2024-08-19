<?php

namespace App\DataFixtures;

use App\Entity\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $priorities = ['Basse', 'Moyenne', 'Haute'];

        foreach ($priorities as $priorityName) {
            $priority = new Priority();
            $priority->setName($priorityName);
            $manager->persist($priority);
        }

        $manager->flush();
    }
}
