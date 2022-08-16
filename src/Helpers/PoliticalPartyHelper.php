<?php

declare(strict_types=1);

namespace Educacaopolitica\Helpers;

use Educacaopolitica\PoliticiansRegister\{Politician, PoliticalParty};
use PDO;
use DateTime;

class PoliticalPartyHelper
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function assignPoliticalParty(
        Politician $politician, 
        PoliticalParty $politicalParty,
        ?DateTime $dateTime
    ) {
        if ($dateTime) {
            $queryInsert = "INSERT INTO `political_party_politician` (
                politician_id, political_party_id, since_from
            ) values (?,?,?);";
            $this->pdo
                ->prepare($queryInsert)
                ->execute([$politician->getId(), $politicalParty->getId(), $dateTime]);
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
