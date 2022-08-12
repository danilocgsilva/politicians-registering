<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

class Photo
{
    private int $id;
    private string $photoPath;

    public function setPhotoPath(string $photoPath): self
    {
        $this->photoPath = $photoPath;
        return $this;
    }

    public function getPhotoPath(): string
    {
        return $this->photoPath;
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
}
