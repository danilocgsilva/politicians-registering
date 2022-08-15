<?php

use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/Migrations/migration_entry_includes.php";
 
$migrate = new Migrate($pdo);

$migrate->migrateTable('politicians');
$migrate->migrateTable('political_parties');
$migrate->migrateTable('photos');
$migrate->migrateTable('political_party_politician_pivot');
