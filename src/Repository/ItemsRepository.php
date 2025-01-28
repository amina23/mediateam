<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemsRepository
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function save(Item $item): void
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
    public function delete(Item $item): void
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    public function getAllItems(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('item')
            ->from(Item::class, 'item')
            ->getQuery()
            ->getResult();
    }

}
