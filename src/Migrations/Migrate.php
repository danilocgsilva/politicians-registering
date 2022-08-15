<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

use PDO;
use Exception;
use Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations\{
    PoliticiansMigration,
    PoliticalPartiesMigration,
    PhotosMigration,
    PoliticalPartyPoliticianPivot
};

class Migrate
{    
    private PDO $pdo;

    private const TABLE_QUERIES = [
        'political_parties' => PoliticalPartiesMigration::class,
        'politicians' => PoliticiansMigration::class,
        'photos' => PhotosMigration::class,
        'political_party_politician_pivot' => PoliticalPartyPoliticianPivot::class,
    ];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function migrateTable(string $table): void
    {
        if (!array_key_exists($table, self::TABLE_QUERIES)) {
            throw new Exception("I don't know the provided table.");
        }

        $this->pdo->prepare(
            (new (
                self::TABLE_QUERIES[$table]
            )())->getQueryCreation()
        )->execute();
    }
}
