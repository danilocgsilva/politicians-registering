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

    public function migrate(): void
    {
        $resource = $this->pdo->prepare($this->generateMigrateScript()); 
        $resource->execute(); 
    }

    public function undoMigrate(): void
    {
        $resource = $this->pdo->prepare($this->generateUndoMigrationScript()); 
        $resource->execute(); 
    }

    private function generateMigrateScript(): string
    {
        return "CREATE TABLE `politicians` (
            id INTEGER AUTO_INCREMENT, name VARCHAR(256), PRIMARY KEY (`id`)
        );";
    }

    private function generateUndoMigrationScript(): string
    {
        return "DROP TABLE `politicians`;";
    }
}
