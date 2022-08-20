<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use PDO;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\{Politician, PoliticalParty};

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

    public function loadPoliticalParties(Politician $politician): void
    {
        $querySelect = "SELECT
            ppp.politician_id,
            ppp.political_party_id,
            pop.name as popname
        FROM political_party_politician ppp
        LEFT JOIN political_parties pop ON pop.id = ppp.political_party_id
        WHERE ppp.politician_id = ?;";

        $resource = $this->pdo->prepare($querySelect);
        $resource->execute([$politician->getId()]);

        while ($result = $resource->fetch()) {
            $politicalParty = (new PoliticalParty())
                ->setName($result["popname"]);
            $politician->addPoliticalParty($politicalParty);
        }
    }
}
