<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adminTest = new Admin('test', 'test');
        $manager->persist($adminTest);

        $manager->flush();
    }
}
