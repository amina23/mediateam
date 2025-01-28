<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    public function __construct(
        private string     $id,
        private string  $username,
        private string  $email,
        private array     $roles = [],
        private  string $password,
        private \DateTime $createdAt,
        private ?\DateTime $updatedAt = null,
    )
    {
        $this->createdAt = new \DateTime();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    public function setPassword(string $hashedPassword): void
    {
         $this->password = $hashedPassword;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

}
