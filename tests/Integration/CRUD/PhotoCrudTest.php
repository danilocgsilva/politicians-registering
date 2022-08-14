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
        $this->photoCrud = new PhotoCrud($this->pdo);
        $this->migrate = new Migrate($this->pdo);
        $this->undoMigration = new UndoMigration($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrateTable('politicians');
        $this->migrate->migrateTable('photos');
    }

    public function tearDown(): void
    {
        $this->undoMigration->deMigrateTable('photos');
        $this->undoMigration->deMigrateTable('politicians');
    }

    public function testRead()
    {
        $this->createPhoto("/var/www/html/public/photos/Hillary_Clinton.jpg");
        $recoveredPhoto = $this->photoCrud->read(1);
        $this->assertInstanceOf(Photo::class, $recoveredPhoto);
        $this->assertSame("/var/www/html/public/photos/Hillary_Clinton.jpg", $recoveredPhoto->getPhotoPath());
    }

    public function testUpdate()
    {
        $this->createPhoto("/var/www/html/public/photos/politicians/BushFather.jpg");
        $this->photoCrud->update(1, "/var/www/html/public/photos/politicians/BushSon.jpg");
        $recoveredPhoto = $this->photoCrud->read(1);
        $this->assertSame("/var/www/html/public/photos/politicians/BushSon.jpg", $recoveredPhoto->getPhotoPath());
    }

    public function testDelete()
    {
        $this->createPhoto("/var/www/html/public/photos/Obama01.png");
        $this->photoCrud->delete(1);
        $this->assertSame(0, $this->photoRepository->count());
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
