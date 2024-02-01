<?php

namespace App\Entity;

class Article
{
    private ?int $id;
    private string $content;
    private string $title;
    private string $description;
    private int $userId;
    private \DateTime $updatedAt;

    public function __construct(?int $id, string $content, string $title, string $description, int $userId, string $updatedAt)
    {
        $this->id = $id;
        $this->content = $content;
        $this->title = $title;
        $this->description = $description;
        $this->userId = $userId;
        $this->updatedAt = new \DateTime($updatedAt);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @throws \Exception
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = new \DateTime($updatedAt);
    }

}