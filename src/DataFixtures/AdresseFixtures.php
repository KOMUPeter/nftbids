<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\Adresse;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdresseFixtures extends Fixture implements DependentFixtureInterface
{
    protected CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $cities = $this->cityRepository->findAll(); // fetch all address propeties to ensure the id is not null 
        $adresses = [
            [
                'line1' => '6 rue bolbec kaltan',
            ],
            [
                'line1' => '6 rue ernest kaltan',
            ],
            [
                'line1' => '6 rue montagnette kaltan',
            ],
        ];

        foreach ($adresses as $key=> $userAdresse) {
            $adresse = new Adresse();
            $adresse->setLine1($userAdresse['line1']);

            $adresse->setCity($cities[$key]); // relationship property

            $manager->persist($adresse);
        }

        $manager->flush();
    }
    public function getDependencies(): array // return depedancies
    {
        return [
            CityFixtures::class,
        ];
    }
}