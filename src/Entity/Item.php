<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Item
{

    private  $subItems;

    public function __construct(
        private string     $id,
        private string  $title,
        private string  $description,
        private \DateTime $createdAt,
        private ?\DateTime $updatedAt = null,
    )
    {
        $this->createdAt = new \DateTime();
        $this->subItems = new ArrayCollection();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /** @return iterable<SubItem> */
    public function getSubItems(): iterable
    {
        return $this->subItems;
    }

    public function addSubItem(SubItem $subItem): void
    {
        $this->subItems[] = $subItem;
    }

    public function update(string $title, string $description): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->updatedAt = new \DateTime();
    }

}
