<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

use PDO;

class PoliticianRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function count(): int
    {
        $queryCount = "SELECT COUNT(id) as count FROM politicians;";
        $resource = $this->pdo->prepare($queryCount);
        $resource->execute();
        $result = $resource->fetch();
        return $result["count"];
    }
}
