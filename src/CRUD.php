<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

use PDO;

class CRUD
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Politician $politician)
    {

    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
