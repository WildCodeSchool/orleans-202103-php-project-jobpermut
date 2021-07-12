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
            'city' => 'Vélizy-Villacoublay',
            'zipCode' => '93100'
        ],
        'n1' => [
            'streetNumber' => '10',
            'street' => 'Avenue Pasteur',
            'city' => 'Créteil',
            'zipCode' => '93100'
        ],
        'n2' => [
            'streetNumber' => '1',
            'street' => 'Avenue Pasteur',
            'city' => 'Arcueil',
            'zipCode' => '93100'
        ],
        'n3' => [
            'streetNumber' => '9',
            'street' => 'Avenue Pasteur',
            'city' => 'Châtillon',
            'zipCode' => '93100'
        ],
        'n4' => [
            'streetNumber' => '11',
            'street' => 'Avenue Pasteur',
            'city' => 'Montrouge',
            'zipCode' => '93100'
        ],
        'n5' => [
            'streetNumber' => '2',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Sèvres',
            'zipCode' => '92500'
        ],
        'n6' => [
            'streetNumber' => '6',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Gagny',
            'zipCode' => '92500'
        ],
        'n7' => [
            'streetNumber' => '8',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Bagnolet',
            'zipCode' => '92500'
        ],
        'n8' => [
            'streetNumber' => '10',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Drancy',
            'zipCode' => '92500'
        ],
        'n9' => [
            'streetNumber' => '4',
            'street' => 'Avenue de Bois Preau',
            'city' => 'Villejuif',
            'zipCode' => '92500'
        ],
    ];

    private const USERS_JOB_ADRESS = [
        'n0' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Meudon',
            'zipCode' => '92500'
        ],
        'n1' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Bobigny',
            'zipCode' => '92500'
        ],
        'n2' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Les Lilas',
            'zipCode' => '92500'
        ],
        'n3' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Montreuil',
            'zipCode' => '92500'
        ],
        'n4' => [
            'streetNumber' => '262',
            'street' => 'Avenue Napoléon Bonaparte',
            'city' => 'Nanterre',
            'zipCode' => '92500'
        ],
        'n5' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Colombes',
            'zipCode' => '93100'
        ],
        'n6' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Vitry-sur-seine',
            'zipCode' => '93100'
        ],
        'n7' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Maisons-Alfort',
            'zipCode' => '93100'
        ],
        'n8' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Vincennes',
            'zipCode' => '93100'
        ],
        'n9' => [
            'streetNumber' => '110',
            'street' => 'Boulevard de la Boissière',
            'city' => 'Clamart',
            'zipCode' => '93100'
        ],
    ];


    public const MAX_REALISTIC_FIXTURES = 50;


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::MAX_REALISTIC_FIXTURES; $i++) {
            $registeredUser = new RegisteredUser();
            $registeredUser->setFirstname($this->faker->firstName());
            $registeredUser->setLastname($this->faker->lastName());
            $registeredUser->setPhone($this->faker->phoneNumber());
            $registeredUser->setStreetNumber(self::USERS_POSTAL_ADRESS['n' . rand(0, 9)]['streetNumber']);
            $registeredUser->setStreet(self::USERS_POSTAL_ADRESS['n' . rand(0, 9)]['street']);
            $registeredUser->setZipcode(self::USERS_POSTAL_ADRESS['n' . rand(0, 9)]['zipCode']);
            $registeredUser->setCity(self::USERS_POSTAL_ADRESS['n' . rand(0, 9)]['city']);
            $registeredUser->setJobStreetNumber(self::USERS_JOB_ADRESS['n' . rand(0, 9)]['streetNumber']);
            $registeredUser->setJobStreet(self::USERS_JOB_ADRESS['n' . rand(0, 9)]['street']);
            $registeredUser->setJobZipcode(self::USERS_JOB_ADRESS['n' . rand(0, 9)]['zipCode']);
            $registeredUser->setCityJob(self::USERS_JOB_ADRESS['n' . rand(0, 9)]['city']);
            $registeredUser->setRome($this->getReference(self::ROME[rand(0, 1)]));
            $registeredUser->setUser($this->getReference('user_' . $i));
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
