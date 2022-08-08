<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister;

use PDO;

class CRUD
{
    private CONST TABLE_NAME = "politicians";
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Politician $politician)
    {
        $this->pdo
            ->prepare(
                sprintf("INSERT INTO %s (name) VALUES (:name);", self::TABLE_NAME)
            )->execute([
                ":name" => $politician->getName()
            ]);
    }

    public function read(int $id): Politician
    {
        $searchQuery = sprintf("SELECT name FROM `%s` WHERE id = ?;", self::TABLE_NAME);
        $resource = $this->pdo->prepare($searchQuery);
        $resource->execute([$id]);
        $result = $resource->fetch();
        return (new Politician())
            ->setName($result["name"])
            ->setId($id);
    }

    public function update(int $id, string $name)
    {
        $this->pdo
            ->prepare(
                sprintf("UPDATE %s SET name = ? WHERE id = ?;", self::TABLE_NAME)
            )->execute([
                $name,
                $id
            ]);
    }

    public function delete(int $id)
    {
        $this->pdo
            ->prepare(
                sprintf("DELETE FROM %s WHERE id = ?;", self::TABLE_NAME)
            )->execute([$id]);
    }
}
