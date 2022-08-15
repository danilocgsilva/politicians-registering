<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations;

class PhotosMigration implements IMigration
{
    public function getQueryCreation(): string
    {
        return 'CREATE TABLE photos (
            id INTEGER AUTO_INCREMENT, 
            path VARCHAR(256), 
            PRIMARY KEY (`id`)
        ); CREATE TABLE photos_politicians (
            politician_id INTEGER, 
            photo_id INTEGER
        ); ALTER TABLE photos_politicians
            ADD CONSTRAINT `politician_id_photos_politicians_politicians` 
            FOREIGN KEY (`politician_id`) 
            REFERENCES `politicians` (`id`);
        ALTER TABLE photos_politicians 
            ADD CONSTRAINT `photo_id_photos_politicians_politicians` 
            FOREIGN KEY (`photo_id`) 
            REFERENCES `photos` (`id`);';
    }
}
