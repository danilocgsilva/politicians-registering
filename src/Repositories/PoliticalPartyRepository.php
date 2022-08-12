<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use Educacaopolitica\PoliticiansRegister\CRUD\PoliticalPartyCrud;
use PDO;
use Educacaopolitica\PoliticiansRegister\PoliticalParty;

class PoliticalPartyRepository implements IRepository
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

    public function save(PoliticalParty $politicalParty): void
    {
        $crud = new PoliticalPartyCrud($this->pdo);
        $crud->create($politicalParty);
    }
}
