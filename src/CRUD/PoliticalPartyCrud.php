<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\CRUD;

use Educacaopolitica\PoliticiansRegister\CRUD\Traits\CRUDTrait;
use Educacaopolitica\PoliticiansRegister\PoliticalParty;
use PDO;

class PoliticalPartyCrud
{
    use CRUDTrait;

    private CONST TABLE_NAME = "political_parties";

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(PoliticalParty $politicalParty)
    {
        $this->pdo
            ->prepare(
                sprintf("INSERT INTO %s (name) VALUES (:name);", self::TABLE_NAME)
            )->execute([
                ":name" => $politicalParty->getName()
            ]);
    }

    public function read(int $id): PoliticalParty
    {
        $searchQuery = sprintf("SELECT name FROM `%s` WHERE id = ?;", self::TABLE_NAME);
        $resource = $this->pdo->prepare($searchQuery);
        $resource->execute([$id]);
        $result = $resource->fetch();
        return (new PoliticalParty())
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

}
