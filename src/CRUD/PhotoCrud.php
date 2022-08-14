<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\CRUD;

use PDO;
use Educacaopolitica\PoliticiansRegister\Photo;
use Educacaopolitica\PoliticiansRegister\CRUD\Traits\CRUDTrait;

class PhotoCrud
{
    use CRUDTrait;

    private CONST TABLE_NAME = "photos";
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Photo $photo)
    {
        $this->pdo
            ->prepare(
                sprintf("INSERT INTO %s (path) VALUES (:path);", self::TABLE_NAME)
            )->execute([
                ":path" => $photo->getPhotoPath()
            ]);
    }

    public function read(int $id): Photo
    {
        $searchQuery = sprintf("SELECT path FROM `%s` WHERE id = ?;", self::TABLE_NAME);
        $resource = $this->pdo->prepare($searchQuery);
        $resource->execute([$id]);
        $result = $resource->fetch();
        return (new Photo())
            ->setPhotoPath($result["path"])
            ->setId($id);
    }

    public function update(int $id, string $photoPath)
    {
        $this->pdo
            ->prepare(
                sprintf("UPDATE %s SET path = ? WHERE id = ?;", self::TABLE_NAME)
            )->execute([
                $photoPath,
                $id
            ]);
    }

}
