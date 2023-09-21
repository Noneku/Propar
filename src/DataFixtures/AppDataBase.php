<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Demande;
use App\Entity\Employe;
use App\Entity\Operation;
use App\Entity\Prestation;
use Faker\Factory as Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppDataBase extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $randomArrayRole = ["Admin", "Expert", "Senior", "Apprenti"];

        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 15; $i++) {
            
            $prestation = new Prestation;
    
            $prestation->setPrix(rand(1000, 6000));
            $prestation->setDescription("Voici la description de ma prestation");
            $prestation->setNom("Grosse");
    
            $manager->persist($prestation);

            $client = new Client();
            $client->setNom($faker->firstName);
            $client->setPrenom($faker->lastName);
            $client->setAdresse($faker->address);
            $client->setEmail($faker->email);
            $client->setTel($faker->phoneNumber);
            $client->setPassword($faker->password);

            $manager->persist($client);

            $employe = new Employe();

            $employe->setNom($faker->firstName);
            $employe->setPrenom($faker->lastName);
            $employe->setMatricule('matricule' . $i);
            $employe->setPassword($faker->password);

            $manager->persist($employe);


            $demande = new Demande;

            $demande->setPrestation($prestation);
            $demande->setClient($client);
            $demande->setDateDemande($faker->dateTime);

            $manager->persist($demande);

            $operation = new Operation();

            $operation->setDemande($demande);
            $operation->setEmploye($employe);
            $operation->setStatus(rand(0, 1));

            $manager->persist($operation);
        }

        $manager->flush();
    }
}