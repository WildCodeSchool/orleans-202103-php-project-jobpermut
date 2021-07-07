<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\RegisteredUser;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RegisteredUserFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;
    private const ROME = ['H2101', 'G1201', 'K1101'];

    private const USERS_POSTAL_ADRESS = [
        'n0' => [
            'streetNumber' => '4',
            'street' => 'Avenue Pasteur',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n1' => [
            'streetNumber' => '10',
            'street' => 'Avenue Pasteur',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n2' => [
            'streetNumber' => '1',
            'street' => 'Avenue Pasteur',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n3' => [
            'streetNumber' => '9',
            'street' => 'Avenue Pasteur',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n4' => [
            'streetNumber' => '11',
            'street' => 'Avenue Pasteur',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n5' => [
            'streetNumber' => '2',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n6' => [
            'streetNumber' => '6',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n7' => [
            'streetNumber' => '8',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n8' => [
            'streetNumber' => '10',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n9' => [
            'streetNumber' => '4',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
    ];

    private const USERS_JOB_ADRESS = [
        'n0' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n1' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n2' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n3' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n4' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Rueil-Malmaison',
            'zipCode' => '92500'
        ],
        'n5' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n6' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n7' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n8' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
        'n9' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Montreuil',
            'zipCode' => '93100'
        ],
    ];


    public const MAX_FIXTURES = 10;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::MAX_FIXTURES; $i++) {
            $registeredUser = new RegisteredUser();
            $registeredUser->setFirstname($this->faker->firstName());
            $registeredUser->setLastname($this->faker->lastName());
            $registeredUser->setPhone($this->faker->phoneNumber());
            $registeredUser->setStreetNumber(self::USERS_POSTAL_ADRESS['n' . $i]['streetNumber']);
            $registeredUser->setStreet(self::USERS_POSTAL_ADRESS['n' . $i]['street']);
            $registeredUser->setZipcode(self::USERS_POSTAL_ADRESS['n' . $i]['zipCode']);
            $registeredUser->setCity(self::USERS_POSTAL_ADRESS['n' . $i]['city']);
            $registeredUser->setJobStreetNumber(self::USERS_JOB_ADRESS['n' . $i]['streetNumber']);
            $registeredUser->setJobStreet(self::USERS_JOB_ADRESS['n' . $i]['street']);
            $registeredUser->setJobZipcode(self::USERS_JOB_ADRESS['n' . $i]['zipCode']);
            $registeredUser->setCityJob(self::USERS_JOB_ADRESS['n' . $i]['city']);
            $registeredUser->setRome($this->getReference(self::ROME[1]));
            $registeredUser->setUser($this->getReference('user_' . $i));
            $registeredUser->setSubscription($this->getReference('subscription_' . $i));

            $manager->persist($registeredUser);
        }

        for ($i = 0; $i < self::MAX_FIXTURES; $i++) {
            $registeredUser = new RegisteredUser();
            $registeredUser->setFirstname($this->faker->firstName());
            $registeredUser->setLastname($this->faker->lastName());
            $registeredUser->setPhone($this->faker->phoneNumber());
            $registeredUser->setStreetNumber($this->faker->buildingNumber());
            $registeredUser->setStreet($this->faker->streetName());
            $registeredUser->setZipcode($this->faker->postcode());
            $registeredUser->setCity($this->faker->city());
            $registeredUser->setJobStreetNumber($this->faker->buildingNumber());
            $registeredUser->setJobStreet($this->faker->streetName());
            $registeredUser->setJobZipcode($this->faker->postcode());
            $registeredUser->setCityJob($this->faker->city());
            $registeredUser->setRome($this->getReference(self::ROME[rand(0, 2)]));
            $registeredUser->setUser($this->getReference('user_' . $i+10));
            $registeredUser->setSubscription($this->getReference('subscription_' . $i));

            $manager->persist($registeredUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SubscriptionFixtures::class,
            RomeFixtures::class,
        ];
    }
}
