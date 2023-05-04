<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixture extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setUsername("admin1");
        $admin1->setFirstName("Admin");
        $admin1->setLastName("Admin");
        $admin1->setNationality("Tunisia");
        $admin1->setAge(14);
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin1->setPassword($this->hasher->hashPassword($admin1,'admin'));
        $admin1->setEmail("MaynaMayna@gmail.com");
        $manager->persist($admin1);

        $manager->flush();
    }
}
