<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use Educacaopolitica\PoliticiansRegister\CRUD\PoliticalPartyCrud;
use Educacaopolitica\PoliticiansRegister\{PoliticalParty, Politician};
use PDO;
use DateTime;

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

    public function assignPoliticalParty(
        Politician $politician, 
        PoliticalParty $politicalParty,
        DateTime $dateTime = null
    ) {
        if ($dateTime) {
            $queryInsert = "INSERT INTO `political_party_politician` (
                politician_id, political_party_id, since_from
            ) values (?,?,?);";
            $this->pdo
                ->prepare($queryInsert)
                ->execute([
                    $politician->getId(), 
                    $politicalParty->getId(),
                    $dateTime->format('Y-m-d h:i:s')
                ]);
        } else {
            $queryInsert = "INSERT INTO `political_party_politician` (
                politician_id, political_party_id
            ) values (?,?);";
            $this->pdo
                ->prepare($queryInsert)
                ->execute([$politician->getId(), $politicalParty->getId()]);
        }
    }
}
