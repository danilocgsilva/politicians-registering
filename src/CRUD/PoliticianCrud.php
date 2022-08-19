<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\CRUD;

use PDO;
use Educacaopolitica\PoliticiansRegister\Politician;
use Educacaopolitica\PoliticiansRegister\CRUD\Traits\CRUDTrait;

class PoliticianCrud
{
    use CRUDTrait;

    private CONST TABLE_NAME = "politicians";
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Politician $politician): void
    {
        $this->pdo
            ->prepare(
                sprintf("INSERT INTO %s (name) VALUES (:name);", self::TABLE_NAME)
            )->execute([
                ":name" => $politician->getName()
            ]);

        if (count($politician->getPhotos()) > 0) {
            $this->savePhotosToDb(
                $this->pdo->lastInsertId(), 
                $politician->getPhotos()
            );
        }
        
        $politician->setId((int) $this->pdo->lastInsertId());
    }

    public function read(int $id): Politician
    {
        $searchQuery = sprintf(
            "SELECT
                p.name as politician_name,
                ph.path as photo_path
            FROM `%s` p
            LEFT JOIN photos_politicians pp ON pp.politician_id = p.id
            LEFT JOIN photos ph ON ph.id = pp.photo_id
            WHERE p.id = ? ;"
            , self::TABLE_NAME
        );
        $resource = $this->pdo->prepare($searchQuery);
        $resource->execute([$id]);

        $recoveredPolitician = new Politician();
        while ($lineResult = $resource->fetch()) {
            $recoveredPolitician->setName($lineResult["politician_name"]);
            if ($lineResult["photo_path"] !== null) {
                $recoveredPolitician->addPhoto($lineResult["photo_path"]);
            }
        }
        return $recoveredPolitician;
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

    private function savePhotosToDb($politicianId, array $photos)
    {
        // if (count($photos) > 0) {

        $insertRow = "INSERT INTO photos (path) VALUES (?)";
        $photosIds = [];
        foreach ($photos as $photo) {
            $this->pdo->prepare($insertRow)->execute([$photo]);
            $photosIds[] = $this->pdo->lastInsertId();
        }

        $valuesToInsertInPivot = "";
        foreach ($photosIds as $photoId) {
            $valuesToInsertInPivot .= sprintf("(%s,%s),", $politicianId, $photoId);
        }
        $valuesToInsertInPivot = rtrim($valuesToInsertInPivot, ",");
        $this->pdo->prepare(
            sprintf(
                "INSERT INTO photos_politicians (politician_id, photo_id) VALUES %s;", 
                $valuesToInsertInPivot
            )
        )->execute();
        // }
    }
}
