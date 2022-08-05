<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

class Migrate
{    
    public function migrate(): string
    {
        $migrationScript = file_get_contents(
            realpath(__DIR__ . "/migrate.sql")
        );

        return $migrationScript;
    }
}
