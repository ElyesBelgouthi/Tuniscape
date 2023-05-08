<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminTestFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setUsername("admin13");
        $admin1->setFirstName("Elyes");
        $admin1->setLastName("Belgouthi");
        $admin1->setNationality("Tunisia");
        $admin1->setAge(15);
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin1->setPassword($this->hasher->hashPassword($admin1,'admin'));
        $admin1->setEmail("samira1a2121@gmail.com");
        $admin1->setIsVerified(true);
        $manager->persist($admin1);

        $manager->flush();
    }
}
