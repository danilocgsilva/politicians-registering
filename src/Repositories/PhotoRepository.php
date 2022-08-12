<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Repositories;

use Educacaopolitica\PoliticiansRegister\CRUD\PhotoCrud;
use PDO;

class PhotoRepository implements IRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function count(): int
    {
        $queryCount = "SELECT COUNT(id) as count FROM photos;";
        $resource = $this->pdo->prepare($queryCount);
        $resource->execute();
        $result = $resource->fetch();
        return $result["count"];
    }

    public function save(Photo $photo): void
    {
        $crud = new PhotoCrud($this->pdo);
        $crud->create($)
    }
}
