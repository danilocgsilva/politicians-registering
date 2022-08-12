<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use PDO;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\Politician;

class PoliticianRepository implements IRepository
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

    public function save(Politician $politician): void
    {
        $crud = new PoliticianCrud($this->pdo);
        $crud->create($politician);
    }
}
