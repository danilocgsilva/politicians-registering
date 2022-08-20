<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations;

class PoliticalPartiesMigration implements IMigration
{
    public function getQueryCreation(): string
    {
        return 'CREATE TABLE `political_parties` (
            id INTEGER AUTO_INCREMENT, 
            name VARCHAR(256), 
            PRIMARY KEY (`id`)
        ); ALTER TABLE politicians
            ADD CONSTRAINT `current_political_party_id`
            FOREIGN KEY (`current_political_party_id`)
            REFERENCES `political_parties` (`id`)';
    }
}
