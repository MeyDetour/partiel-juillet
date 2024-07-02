<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Room;
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
        $rooms = [
            "1" => 85,
            "2" => 45,
            "3" => 45,
            "4" => 45,
            "5" => 45,
            "6" => 45,
        ];
        foreach ($rooms as $name => $places) {
            $room = new Room();
            $room->setName($name);
            $room->setPlaces($places);
            $manager->persist($room);
        }

        $themes = ['Action',
            'Aventure',
            'Comédie',
            'Comédie dramatique',
            'Drame',
            'Fantastique',
            'Guerre',
            'Policier'];
        foreach ($themes as $theme) {
            $cat = new Category();
            $cat->setName($theme);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
