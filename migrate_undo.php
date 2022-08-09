<?php

use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/Migrations/migration_entry_includes.php";
 
$migrate = new UndoMigration($pdo);
$migrate->deMigrateTable('politicians');
$migrate->deMigrateTable('political_parties');