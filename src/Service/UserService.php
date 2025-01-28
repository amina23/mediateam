<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository              $userRepository,
    )
    {
    }

    public function createUser(UserDTO $userDto): User
    {
        $user = new User((Uuid::v6())->toString(), $userDto->username, $userDto->email, ['ROLE_ADMIN'], $userDto->password, new \DateTime());
        $user->setPassword($this->passwordHasher->hashPassword($user, $userDto->password));

        $this->userRepository->save($user);
        $this->userRepository->flush();

        return $user;
    }
}
