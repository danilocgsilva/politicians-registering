<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

use PDO;

class Politician
{
    private int $id;
    private string $name;
    private array $photos = [];
    private array $politicalParties = [];

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

    public function loadPoliticalParties(PDO $pdo): void
    {
        $querySelect = "SELECT
            ppp.politician_id,
            ppp.political_party_id,
            pop.name as popname
        FROM political_party_politician ppp
        LEFT JOIN political_parties pop ON pop.id = ppp.political_party_id
        WHERE ppp.politician_id = ?;";

        $resource = $pdo->prepare($querySelect);
        $resource->execute([$this->getId()]);

        while ($result = $resource->fetch()) {
            $politicalParty = (new PoliticalParty())
                ->setName($result["popname"]);
            $this->politicalParties[] = $politicalParty;
        }
    }

    public function getPoliticalPartiesHistory(): array
    {
        return $this->politicalParties;
    }
}
