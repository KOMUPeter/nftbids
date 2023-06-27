<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Repository\AdresseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cities = [
            ['cityName'=>'Paris',
            'postalCode'=> 75001,
            ],
            ['cityName'=>'Lyon',
            'postalCode'=> 69001,
            ],
            ['cityName'=>'Toulouse',
            'postalCode'=> 31001,
            ],
        ];
        foreach ($cities as $cityN) {
            $city=new city();
            $city->setCityName($cityN['cityName']);
            $city->setPostalCode($cityN['postalCode']);

            $manager->persist($city);
        }

        $manager->flush();
    }
}
