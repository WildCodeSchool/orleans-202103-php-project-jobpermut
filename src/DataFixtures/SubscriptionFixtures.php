<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SubscriptionFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UserFixtures::MAX_FIXTURES; $i++) {
            $subscription = new Subscription();
            $subscription->setSubscriptionAt($this->faker->dateTimeBetween('-2 week', 'now'));
            $subscription->setCurriculum($this->faker->mimeType());
            $subscription->setJobDescription($this->faker->sentence(4));

            $manager->persist($subscription);
            $this->addReference('subscription_' . $i, $subscription);
        }

        $manager->flush();
    }
}
