<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

class Politician
{
    private int $id;
    private string $name;
    private array $photos = [];

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addPhoto(string $photoPath): self
    {
        $this->photos[] = $photoPath;
        return $this;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function countPhotos(): int
    {
        return count($this->photos);
    }
}
