<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

use Exception;
use PDO;

class UndoMigration
{
    private const TABLE_QUERIES = [
        'political_parties' => 'DROP TABLE `political_parties`;',
        'politicians' => 'DROP TABLE `politicians`;',
        'photos' => 'DROP TABLE `photos`; DROP TABLE `photos_politicians`;'
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