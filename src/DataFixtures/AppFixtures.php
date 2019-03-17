<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Entity\Page;
use App\Service\EncryptingService;
use App\Service\SlugGeneratorService;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * Les fixtures suivantes sont à utiliser en dévelopement.
         * Il est fortement déconseillé de les appliquer sur la base de données en production.
         */

         /**
          * Création de l'admin test
          * Mail : test@example.com
          * Mot de passe : test
          */
        $encryptingService = new EncryptingService("test");
        $admin = new Admin("test@example.com", $encryptingService->getEncryptedString());
        $manager->persist($admin);

        $page = new Page("Page Test");
        $manager->persist($page);

        $manager->flush();
    }
}
