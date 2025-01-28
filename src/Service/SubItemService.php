<?php

namespace App\Service;

use App\DTO\SubItemDTO;
use App\Entity\Item;
use App\Entity\SubItem;
use App\Repository\SubItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class SubItemService
{
    public function __construct(private SubItemRepository $subItemRepository, private EntityManagerInterface $entityManager)
    {
    }

    public function addSubItem(SubItemDTO $subItemDTO): SubItem
    {

        $item = $this->entityManager->getRepository(Item::class)->find($subItemDTO->item->getId());
        $subItem = new SubItem((Uuid::v6())->toString(), $subItemDTO->title, $subItemDTO->description, $item, new \DateTime());
        $this->subItemRepository->save($subItem);

        return $subItem;
    }

    public function updateSubItem(SubItemDTO $subItemDTO, SubItem $subItem): SubItem
    {
        $item = $this->entityManager->getRepository(Item::class)->find($subItemDTO->item->getId());
        $subItem->update($subItemDTO->title, $subItemDTO->description, $item);
        $this->subItemRepository->save($subItem);

        return $subItem;
    }

    public function removeSubItem(SubItem $subItem): void
    {
        $this->subItemRepository->delete($subItem);

    }

}
