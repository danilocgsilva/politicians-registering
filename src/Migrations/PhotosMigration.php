<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

class PhotosMigration implements IMigration
{
    public function getQueryCreation(): string
    {
        return 'CREATE TABLE photos (
            id INTEGER AUTO_INCREMENT, path VARCHAR(256), PRIMARY KEY (`id`)
        ); CREATE TABLE photos_politicians (
            politician_id INTEGER, photo_id INTEGER
        );';
    }
}
