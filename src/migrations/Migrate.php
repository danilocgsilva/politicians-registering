<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

use PDO;

class Migrate
{    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function migratePoliticiansTable(): void
    {
        $resource = $this->pdo->prepare($this->generateMigratePoliticianScript()); 
        $resource->execute(); 
    }

    private function generatePoliticalPartiesScript(): string
    {
        return "CREATE TABLE `political_parties` (
            id INTEGER AUTO_INCREMENT, name VARCHAR(256), PRIMARY KEY (`id`)
        )";
    }

    public function undoPoliticiansTableMigrate(): void
    {
        $resource = $this->pdo->prepare($this->generateUndoMigrationScript()); 
        $resource->execute(); 
    }

    private function generateMigratePoliticianScript(): string
    {
        return "CREATE TABLE `politicians` (
            id INTEGER AUTO_INCREMENT, name VARCHAR(256), PRIMARY KEY (`id`)
        );";
    }

    private function generateUndoMigrationScript(): string
    {
        return "DROP TABLE `politicians`; DROP TABLE `political_party`;";
    }
}
