<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setFirstName('User')
            ->setLastName('Lambda')
            ->setBirthDate((new \DateTime())->setDate(1998, 06, 11))
            ->setRoles([ 'ROLE_USER' ])
            ->setEmail('drakx116@gmail.com')
            ->setPassword(
                $this->passwordHasher->hashPassword($user, 'admin')
            );

        $manager->persist($user);
        $manager->flush();
    }
}
