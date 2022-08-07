<?php

require "vendor/autoload.php";

use Danilocgsilva\PdoStringBuilder\Builder;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;

$pdoString = (new Builder())
    ->setDbDns(getenv("DATABASE_DNS"))
    ->setDbName(getenv("DATABASE_NAME"))
    ->getPdoString();

$pdo = new PDO($pdoString, getenv("DATABASE_USER"), getenv("DATABASE_PASSWORD"));

$migrate = new Migrate($pdo);

$migrate->undoMigrate();