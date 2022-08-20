<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations;

class PoliticiansMigration implements IMigration
{
    public function getQueryCreation(): string
    {
        return 'CREATE TABLE `politicians` (
            id INTEGER AUTO_INCREMENT, 
            name VARCHAR(256), 
            current_political_party_id INTEGER, 
            PRIMARY KEY (`id`)
        );';
    }
}
