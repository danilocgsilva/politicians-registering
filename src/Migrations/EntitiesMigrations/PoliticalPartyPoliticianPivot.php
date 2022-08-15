<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations;

class PoliticalPartyPoliticianPivot implements IMigration
{
    public function getQueryCreation(): string
    {
        return 'CREATE TABLE `political_party_politician` (
            politician_id INTEGER, 
            political_party_id INTEGER, 
            since_from DATETIME
        ); ALTER TABLE political_party_politician 
            ADD CONSTRAINT `politician_id_politicians` 
            FOREIGN KEY (`politician_id`)
            REFERENCES `politicians` (`id`);
        ALTER TABLE political_party_politician
            ADD CONSTRAINT `political_party_id`
            FOREIGN KEY (`political_party_id`)
            REFERENCES `political_parties` (`id`);';
    }
}

