<?php

namespace App\Service;

use App\DTO\ItemDTO;
use App\Entity\Item;
use App\Repository\ItemsRepository;
use DateTime;
use Symfony\Component\Uid\Uuid;

class ItemsService
{

    public function __construct(private ItemsRepository $itemsRepository)
    {
    }

    public function addItem (ItemDTO $itemDto): Item
    {
        $item = new Item((Uuid::v6())->toString(), $itemDto->title, $itemDto->description, new DateTime());
        $this->itemsRepository->save($item);

        return $item;
    }

    public function updateItem (Item $item, ItemDTO $itemDto): Item
    {
        $item->update($itemDto->title, $itemDto->description);
        $this->itemsRepository->save($item);
        return $item;
    }

    public function removeItem (Item $item): void
    {
        $this->itemsRepository->delete($item);
    }

}
