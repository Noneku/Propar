<?php

namespace App\DataFixtures;

use App\Entity\Prestations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class Prestation extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 3; $i++) {        

            $prestation = new Prestations;
            $prestation->setPrix(10000);
            $prestation->setDescription("Voici la description de ma prestation");
            $prestation->setNom("Grosse");

            $manager->persist($prestation);
        }

        $manager->flush();
    }
}
