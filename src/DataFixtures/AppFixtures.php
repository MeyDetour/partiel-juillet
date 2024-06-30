<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('meydetour@gmail.com');
        $user->setPassword('$2y$13$hbIplez5P6zW0KqBcNp3eOuHudTmOm8Ey/Y.kXpe.dHwAyS860CD.');
        $user->setRoles(["ROLE_ADMIN"]);

          $manager->persist($user);
         $manager->flush();
    }
}
