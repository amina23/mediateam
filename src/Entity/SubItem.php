<?php

namespace App\Entity;


class SubItem
{

    public function __construct(
        private string     $id,
        private string  $title,
        private string  $description,
        private Item $item,
        private \DateTime $createdAt,
        private ?\DateTime $updatedAt = null,
    )
    {
        $this->createdAt = new \DateTime();
    }


    // Getters and Setters

    public function getId(): string
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function update(string $title, string $description, Item $item): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->item = $item;
        $this->updatedAt = new \DateTime();
    }
}
