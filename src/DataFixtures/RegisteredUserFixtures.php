<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\RegisteredUser;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegisteredUserFixtures extends Fixture
{
    private const REGISTERED_USERS = [];

    private const MAX_FIXTURES = 10;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
