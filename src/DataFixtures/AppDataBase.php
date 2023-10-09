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
        $prestationsArray = [
            "Grosse" => "Description",
            "Moyenne" => "Description",
            "Petite" => "Description"
            ];

        $faker = Faker::create('fr_FR');
        
        //Create GapCount for avoid duplicates ID in database
        $gapCount = 0;

        foreach ($prestationsArray as $nomPrestation => $descriptionPrestation) {
            
            $prestation = new Prestation;
            
            $prestation->setPrix(rand(1000, 6000));
            $prestation->setNom($nomPrestation);
            $prestation->setDescription($descriptionPrestation);
            
            $manager->persist($prestation);
            
            for ($g = $gapCount; $g < 20; $g++) { 
                
                $gapCount += $g;

                $client = new Client();
                $client->setNom($faker->firstName);
                $client->setPrenom($faker->lastName);
                $client->setAdresse($faker->address);
                $client->setEmail($faker->email);
                $client->setTel($faker->phoneNumber);
                $client->setPassword($faker->password);
                $client->setRoles(['ROLE_USER']);
                $client->setDescriptionClient("Ceci c'est du text");
                
                $manager->persist($client);
                
                $employe = new Employe();
                
                $employe->setNom($faker->firstName);
                $employe->setPrenom($faker->lastName);
                $employe->setMatricule('matricule' . $g);
                $employe->setPassword($faker->password);
                $employe->setRoles($randomArrayRole[rand(0,3)]);
                
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
                $operation->setDateOperation($faker->dateTime);
                (!$operation->getStatus()) ? $operation->setDateFinOperation($faker->dateTime) : null;
    
                $manager->persist($operation);

            }
            $manager->flush();
        }

        $manager->flush();
    }
}