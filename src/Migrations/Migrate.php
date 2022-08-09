<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

use PDO;
use Exception;

class Migrate
{    
    private PDO $pdo;

    private const TABLE_QUERIES = [
        'political_parties' => 'CREATE TABLE `political_parties` (
            id INTEGER AUTO_INCREMENT, name VARCHAR(256), PRIMARY KEY (`id`)
        )',
        'politicians' => 'CREATE TABLE `politicians` (
            id INTEGER AUTO_INCREMENT, name VARCHAR(256), PRIMARY KEY (`id`)
        );'
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
        $resource = $this->pdo->prepare(self::TABLE_QUERIES[$table]);
        $resource->execute();
    }
}
