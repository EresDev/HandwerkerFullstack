<?php

namespace App\Domain\Entity;

class Job extends Entity
{
    private string $title;
    private string $zipCode;
    private string $city;
    private string $description;
    private \DateTime $executionDateTime;
    private int $categoryId;
    private string $poster;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        \DateTime $executionDateTime,
        int $categoryId,
        string $userId
    ) {
        parent::__construct($uuid);

        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->categoryId = $categoryId;
        $this->poster = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getExecutionDateTime(): \DateTime
    {
        return $this->executionDateTime;
    }

    public function setExecutionDateTime(\DateTime $executionDateTime): void
    {
        $this->executionDateTime = $executionDateTime;
    }

    public function getCategoryId(): Category
    {
        return $this->categoryId;
    }

    public function setCategoryId(Category $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getPoster(): string
    {
        return $this->poster;
    }

    public function setPoster(User $poster): void
    {
        $this->poster = $poster;
    }
}
