<?php

use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/Migrations/migration_entry_includes.php";
 
$undoMigrate = new UndoMigration($pdo);

$undoMigrate->deMigrateTable('political_party_politician_pivot');
$undoMigrate->deMigrateTable('photos');
$undoMigrate->deMigrateTable('political_parties');
$undoMigrate->deMigrateTable('politicians');