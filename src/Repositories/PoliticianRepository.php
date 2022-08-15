<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use PDO;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\Politician;

class PoliticianRepository implements IRepository
{
    private PDO $pdo;
    private PoliticianCrud $politicanCrud;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->politicanCrud = new PoliticianCrud($this->pdo);
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
        $this->politicanCrud->create($politician);
    }

    public function read(int $number): Politician
    {
        return $this->politicanCrud->read($number);
    }
}
