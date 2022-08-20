<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

use Exception;
use PDO;

class UndoMigration
{
    private const TABLE_QUERIES = [

        'political_parties' => 'ALTER TABLE `politicians`
            DROP FOREIGN KEY `current_political_party_id`; 
            DROP TABLE `political_parties`;',

        'politicians' => 'DROP TABLE `politicians`;',

        'photos' => 
            'ALTER TABLE photos_politicians 
                DROP FOREIGN KEY `politician_id_photos_politicians_politicians`;
            ALTER TABLE photos_politicians 
                DROP FOREIGN KEY `photo_id_photos_politicians_politicians`;
            DROP TABLE `photos`; 
            DROP TABLE `photos_politicians`;',

        'political_party_politician_pivot' => 
            'ALTER TABLE `political_party_politician`
                DROP FOREIGN KEY `politician_id_politicians`;
            ALTER TABLE `political_party_politician`
                DROP FOREIGN KEY `political_party_id`;
            DROP TABLE `political_party_politician`;'
    ];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function deMigrateTable(string $table): void
    {
        if (!array_key_exists($table, self::TABLE_QUERIES)) {
            throw new Exception("I don't know the provided table.");
        }
        $resource = $this->pdo->prepare(self::TABLE_QUERIES[$table]);

        $resource->execute();
    }
}