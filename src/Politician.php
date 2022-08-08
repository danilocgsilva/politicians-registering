<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

class Politician
{
    private int $id;
    private string $name;

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

    public function getid(): int
    {
        return $this->id;
    }
}
