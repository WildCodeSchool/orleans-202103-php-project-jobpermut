<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\RegisteredUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class RegisteredUserFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UserFixtures::MAX_FIXTURES; $i++) {
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
            $registeredUser->setOgr($this->faker->randomNumber());
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
        ];
    }
}
