<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
    }
    
    public function flush(): void
    {
        $this->entityManager->flush();
    }


}
