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
        return file_get_contents(
            realpath(__DIR__ . "/migrate.sql")
        );
    }

    private function generateUndoMigrationScript(): string
    {
        return file_get_contents(
            realpath(__DIR__ . "/undo_migrate.sql")
        );
    }
}
