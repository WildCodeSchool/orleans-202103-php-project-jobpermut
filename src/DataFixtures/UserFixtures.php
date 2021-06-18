<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private const USERS_PASSWORDS = [
        'user' => [
            'password' => '123456789',
            'role' => ['ROLE_USER'],
        ],
        'admin' => [
            'password' => 'admin123456789',
            'role' => ['ROLE_ADMIN'],
        ],
        'superadmin' => [
            'password' => 'admin123456789',
            'role' => ['ROLE_SUPERADMIN'],
        ],
    ];

    public const MAX_FIXTURES = 10;

    private UserPasswordEncoderInterface $passwordEncoder;
    private Generator $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();

        //for ROLE_USER
        for ($i = 0; $i < self::MAX_FIXTURES; $i++) {
            $user = new User();
            $user->setEmail($this->faker->unique()->email());
            $user->setRoles(self::USERS_PASSWORDS['user']['role']);
            $user->setCreatedAt($this->faker->dateTimeBetween('-2 week', 'now'));
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    self::USERS_PASSWORDS['user']['password']
                )
            );
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        //for use in demo
        $user = new User();
        $user->setEmail('wildjobexchangeUser@gmail.com');
        $user->setRoles(self::USERS_PASSWORDS['user']['role']);
        $user->setCreatedAt($this->faker->dateTimeBetween('-2 week', 'now'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, self::USERS_PASSWORDS['user']['password']));
        $manager->persist($user);

        //for ROLE_ADMIN
        $user = new User();
        $user->setEmail('wildjobexchangeAdmin@gmail.com');
        $user->setRoles(self::USERS_PASSWORDS['admin']['role']);
        $user->setCreatedAt($this->faker->dateTimeBetween('-2 week', 'now'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, self::USERS_PASSWORDS['admin']['password']));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('wildjobexchangeSuperAdmin@gmail.com');
        $user->setRoles(self::USERS_PASSWORDS['superadmin']['role']);
        $user->setCreatedAt($this->faker->dateTimeBetween('-2 week', 'now'));
        $user->setPassword(
            $this
                ->passwordEncoder
                ->encodePassword($user, self::USERS_PASSWORDS['superadmin']['password'])
        );
        $manager->persist($user);

        $manager->flush();
    }
}
