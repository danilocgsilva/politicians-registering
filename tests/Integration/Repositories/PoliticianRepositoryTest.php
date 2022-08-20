<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration\Repositories;

use Educacaopolitica\PoliticiansRegister\Repositories\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use Educacaopolitica\PoliticiansRegister\Politician;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use PDO;
use PHPUnit\Framework\TestCase;

class PoliticianRepositoryTest extends TestCase
{
    use DbTrait;
    
    private PoliticianRepository $repository;
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->repository = new PoliticianRepository($this->pdo);
        $this->undoMigration = new UndoMigration($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrateTable('politicians');
    }

    public function tearDown(): void
    {
        $this->undoMigration->deMigrateTable('politicians');
    }

    public function testRepositoryCount()
    {
        $this->assertSame(0, $this->repository->count());
    }

    public function testWithPhotos()
    {
        $politicianWithPhoto = $this->setNewPolitician(
            "José Antonio Kast",
            [
                "/var/www/html/public/images/JoseAntonioKast01.png",
                "/var/www/html/public/images/JoseAntonioKast02.png"
            ]
        );

        $this->assertSame(2, $politicianWithPhoto->countPhotos());
    }

    public function testGetPhotosFromDb()
    {
        $this->migrate->migrateTable('photos');

        $politicianWithFotosInDb = $this->setNewPolitician(
            "Angela Merkel",
            [
                "/var/www/html/public/photos/german/angela_merkel01.png",
                "/var/www/html/public/photos/german/angela_merkel02.png",
                "/var/www/html/public/photos/german/angelaMerkel3.png"
            ]
        );

        $this->repository->save($politicianWithFotosInDb);
        $recovered = $this->repository->read(1);
        $this->assertCount(3, $recovered->getPhotos());

        $this->undoMigration->deMigrateTable('photos');
    }

    public function testSave()
    {
        $politician = new Politician();
        $politician->setName("Sebastián Piñera");
        $this->repository->save($politician);
        $this->assertSame(1, $this->repository->count());
    }

    private function setNewPolitician(string $name, array $photos): Politician
    {
        $politicianWithFotos = new Politician();

        $politicianWithFotos->setName($name);

        array_map(function($photoPath) use ($politicianWithFotos) {
                $politicianWithFotos->addPhoto($photoPath);
            }, $photos
        );

        return $politicianWithFotos;
    }
}