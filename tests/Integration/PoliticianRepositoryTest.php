<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

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
        $this->migrate = new Migrate($this->pdo);
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

    public function testDbWithPhotos()
    {
        $politicianWithPhoto = new Politician();

        $name = "José Antonio Kast";
        
        $photoPath1 = "/var/www/html/public/images/JoseAntonioKast01.png";
        $photoPath2 = "/var/www/html/public/images/JoseAntonioKast02.png";

        $politicianWithPhoto->setName($name)
            ->addPhoto($photoPath1)
            ->addPhoto($photoPath2);
    }

    public function testSave()
    {
        $politician = new Politician();
        $politician->setName("Sebastián Piñera");
        $this->repository->save($politician);
        $this->assertSame(1, $this->repository->count());
    }
}