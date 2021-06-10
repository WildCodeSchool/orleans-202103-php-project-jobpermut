<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\RegisteredUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegisteredUserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UserFixtures::MAX_FIXTURES; $i++) {
            $registeredUser = new RegisteredUser();
            $registeredUser->setPseudo($this->faker->unique()->firstName() . $this->faker->randomNumber());
            $registeredUser->setFirstname($this->faker->firstName());
            $registeredUser->setLastname($this->faker->lastName());
            $registeredUser->setPhone($this->faker->randomNumber());
            $registeredUser->setAddress($this->faker->streetAddress());
            $registeredUser->setJobAddress($this->faker->streetAddress());
            $registeredUser->setOgr($this->faker->randomNumber());
            $registeredUser->setUser($this->getReference('user_' . $i));

            $manager->persist($registeredUser);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
