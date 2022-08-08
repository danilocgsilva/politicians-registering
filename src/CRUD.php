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
        $createQuery = sprintf(
            "INSERT INTO `%s` VALUES \"%s\";", 
            self::TABLE_NAME, 
            $politician->getName()
        );
        $this->pdo->prepare($createQuery);
        $this->pdo->execute();
    }

    public function read(int $id): Politician
    {
        $searchQuery = "SELECT name FROM `%s` WHERE id = ?;";
        $resource = $this->pdo->prepare($searchQuery);
        $resource->execute([$id]);
        $result = $resource->fetch();
        return (new Politician())
            ->setName($result["name"])
            ->setId($id);
    }

    public function update(int $id, string $name)
    {
        $queryUpdate = "UPDATE ? SET name = \"?\" WHERE id = ?;";
        $this->pdo->prepare($queryUpdate);
        $this->pdo->execute([
            self::TABLE_NAME,
            $name,
            $id
        ]);
    }

    public function delete(int $id)
    {
        $queryDelete = "DELETE FROM ? WHERE id = ?;";
        $this->pdo->prepare($queryDelete);
        $this->pdo->execute([
            self::TABLE_NAME,
            $id
        ]);
    }
}
