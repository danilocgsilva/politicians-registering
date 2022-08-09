<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Traits;

use Danilocgsilva\PdoStringBuilder\Builder;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;
use PDO;

trait DbTrait
{
    public function db()
    {
        $pdoStringBuilder = (new Builder())
            ->setDbDns(getenv("DATABASE_DNS"))
            ->setDbName(getenv("DATABASE_NAME"));
        $this->pdo = new PDO(
            $pdoStringBuilder->getPdoString(), 
            getenv("DATABASE_USER"), 
            getenv("DATABASE_PASSWORD")
        );
        $this->migrate = new Migrate($this->pdo);
    }
}