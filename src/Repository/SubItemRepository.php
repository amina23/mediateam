<?php

namespace App\Repository;

use App\Entity\SubItem;
use Doctrine\ORM\EntityManagerInterface;

class SubItemRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function save(SubItem $item): void
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    public function delete(SubItem $subItem): void
    {
        $this->entityManager->remove($subItem);
        $this->entityManager->flush();
    }

    public function getAllSubItem(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('subItem')
            ->from(SubItem::class, 'subItem')
            ->getQuery()
            ->getResult();
    }
}
