<?php

use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/Migrations/migration_entry_includes.php";
 
$undoMigrate = new UndoMigration($pdo);

$undoMigrate->deMigrateTable('politicians');
$undoMigrate->deMigrateTable('political_parties');
$undoMigrate->deMigrateTable('photos');