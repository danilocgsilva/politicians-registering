<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

class PoliticianPhoto
{
    private int $id;
    private string $path;

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getpath(): string
    {
        return $this->path;
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
