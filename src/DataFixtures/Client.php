<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Client extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 15; $i++) { 
            $client = new Clients();
            $client->setNom('Gacem');
            $client->setPrenom('Nassim');
            $client->setAdresse('33 avenue de la haie');
            $client->setEmail('lolipop@gmail.com');
            $client->setTel('064587812');
            $client->setPassword('rex2564');

            $manager->persist($client);
        }
    
        $manager->flush();
    }
}
