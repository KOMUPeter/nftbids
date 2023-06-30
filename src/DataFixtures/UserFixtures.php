<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\AdresseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    protected UserPasswordHasherInterface $hasher;
    protected AdresseRepository $adresseRepository;

    public function __construct(UserPasswordHasherInterface $hasher, AdresseRepository $adresseRepository)
    {
        $this->hasher = $hasher;
        $this->adresseRepository = $adresseRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $adresses = $this->adresseRepository->findAll(); // fetch all address propeties to ensure the id is not null  

        $users = [
            [
                'password' => '1010',
                'email' => 'admin@yahoo.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'gender' => 'male',
                'dateOfBirth' => '1997/12/10',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN']
            ],
            [
                'password' => '2010',
                'email' => 'user@yahoo.com',
                'firstName' => 'User1',
                'lastName' => 'Doe',
                'gender' => 'Female',
                'dateOfBirth' => '1990/02/17',
                'roles' => ['ROLE_SELLER']
            ],
            [
                'password' => '3010',
                'email' => 'buyer@yahoo.com',
                'firstName' => 'Buyer1',
                'lastName' => 'Doe',
                'gender' => 'male',
                'dateOfBirth' => '1988/03/01',
                'roles' => ['ROLE_SELLER', 'ROLE_BUYER']
            ],
        ];

        foreach ($users as $key => $userData) {
            $user = new User();
            $user->setPassword($this->hasher->hashPassword($user, $userData['password'])); // password harsh always taks in two parameters
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            $user->setGender($userData['gender']);
            $user->setDateOfBirth(new \DateTime($userData['dateOfBirth']));
            $user->setRoles($userData['roles']);

            $user->setLives($adresses[$key]); // relationship property

            // prepare the request with persist
            $manager->persist($user);


        }

        $manager->flush();
    }


    public function getDependencies(): array  // return depedancies
    {
        return [
            AdresseFixtures::class,
        ];
    }
}