<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use App\Entity\Demandes;
use App\Entity\Employes;
use App\Entity\Operations;
use App\Entity\Prestations;
use Faker\Factory as Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppData extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $randomArrayRole = ["Admin", "Expert", "Senior", "Apprenti"];

        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 15; $i++) {
            
            $prestation = new Prestations;
    
            $prestation->setPrix(rand(1000, 6000));
            $prestation->setDescription("Voici la description de ma prestation");
            $prestation->setNom("Grosse");
    
            $manager->persist($prestation);

            $client = new Clients();
            $client->setNom($faker->firstName);
            $client->setPrenom($faker->lastName);
            $client->setAdresse($faker->address);
            $client->setEmail($faker->email);
            $client->setTel($faker->phoneNumber);
            $client->setPassword($faker->password);

            $manager->persist($client);

            $employe = new Employes();

            $employe->setNom($faker->firstName);
            $employe->setPrenom($faker->lastName);
            $employe->setMatricule("XX11254VMOP");
            $employe->setPassword($faker->password);
            $employe->setRole($randomArrayRole[rand(0,3)]);

            $manager->persist($employe);


            $demande = new Demandes;

            $demande->setPrestation($prestation);
            $demande->setClient($client);
            $demande->setDateDemande($faker->dateTime);

            $manager->persist($demande);

            $operation = new Operations();

            $operation->setDemandes($demande);
            $operation->setEmploye($employe);
            $operation->setStatus(rand(0, 1));

            $manager->persist($operation);
        }

        $manager->flush();
    }
}
