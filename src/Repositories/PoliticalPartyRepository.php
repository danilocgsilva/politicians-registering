<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use PDO;

class PoliticalPartyRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function count(): int
    {
        $queryCount = "SELECT COUNT(id) as count FROM political_parties;";
        $resource = $this->pdo->prepare($queryCount);
        $resource->execute();
        $result = $resource->fetch();
        return $result["count"];
    }
}
