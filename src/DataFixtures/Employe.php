<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class Employe extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 15; $i++) { 
            
            $employe = new Employes();
            $employe->setNom($faker->firstName);
            $employe->setPrenom($faker->lastName);
            $employe->setMatricule($faker->address);
            $employe->setPassword($faker->password);
            $employe->setRole("Test");


            $manager->persist($employe);
        }

        $manager->flush();
    }
}
