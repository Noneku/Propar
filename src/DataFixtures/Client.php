<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
class Client extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 15; $i++) { 
            
            $client = new Clients();
            $client->setNom($faker->firstName);
            $client->setPrenom($faker->lastName);
            $client->setAdresse($faker->address);
            $client->setEmail($faker->email);
            $client->setTel($faker->phoneNumber);
            $client->setPassword($faker->password);

            $manager->persist($client);
        }
    
        $manager->flush();
    }
}
