<?php

namespace App\Entity;

class User {

    private ?int $id;
    private string $firstName;
    private string $lastName;
    private string $description;
    private string $resume;
    private string $profilPicture;
    private string $password;
    private array $links;
    private array $roles;

    public function __construct(?int $id, string $firstName, string $lastName, string $description, string $resume, string $profilPicture, string $password, array $links, array $roles)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->description = $description;
        $this->resume = $resume;
        $this->profilPicture = $profilPicture;
        $this->password = $password;
        $this->links = $links;
        $this->roles = $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getResume(): string
    {
        return $this->resume;
    }

    public function setResume(string $resume): void
    {
        $this->resume = $resume;
    }

    public function getProfilPicture(): string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(string $profilPicture): void
    {
        $this->profilPicture = $profilPicture;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(array $links): void
    {
        $this->links = $links;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }


}