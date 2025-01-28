<?php

namespace App\DTO;

use App\Entity\Item;

class SubItemDTO
{

    public string $title;
    public string $description;
    public Item $item;
}
