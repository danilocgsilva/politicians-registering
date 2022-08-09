<?php

use Danilocgsilva\PdoStringBuilder\Builder;

$pdoString = (new Builder())
    ->setDbDns(getenv("DATABASE_DNS"))
    ->setDbName(getenv("DATABASE_NAME"))
    ->getPdoString();

$pdo = new PDO(
    $pdoString, 
    getenv("DATABASE_USER"), 
    getenv("DATABASE_PASSWORD")
);
