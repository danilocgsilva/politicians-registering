<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use Educacaopolitica\PoliticiansRegister\CRUD\PhotoCrud;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use Educacaopolitica\PoliticiansRegister\Migrations\{UndoMigration, Migrate};
use Educacaopolitica\PoliticiansRegister\Repositories\PhotoRepository;
use Educacaopolitica\PoliticiansRegister\Photo;
use PHPUnit\Framework\TestCase;
use PDO;

class PhotoCrudTest extends TestCase implements ICrudTest
{
    use DbTrait;

    private PhotoCrud $photoCrud;
    private PDO $pdo;
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PhotoRepository $photoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->photoRepository = new PhotoRepository($this->pdo);
    }

    public function testRead()
    {
        $this->assertTrue(false);
    }

    public function testUpdate()
    {
        $this->assertTrue(false);
    }

    public function testDelete()
    {
        $this->assertTrue(false);
    }

    public function testCreate()
    {
        $this->assertSame(0, $this->photoRepository->count());
        $photoPath = "/var/www/html/public/photos/FernandoHenriqueCardoso.png";
        $this->createPhoto($photoPath);
        $this->assertSame(1, $this->photoRepository->count());
    }
    
    private function createPhoto(string $photoPath)
    {
        $newPhoto = (new Photo())
            ->setPhotoPath($photoPath);
        $this->photoCrud->create($newPhoto);
    }
}
