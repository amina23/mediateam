<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
    )
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User((Uuid::v6())->toString(), 'app', 'app.test@gmail.com', ['ROLE_ADMIN'], 'app', new \DateTime());
        $user->setPassword($this->passwordHasher->hashPassword($user, 'app'));
        $this->entityManager->persist($user);

        $manager->flush();
    }
}
