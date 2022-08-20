<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Politician;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\{DbTrait, CreatorDBTrait};
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use PDO;

class PoliticianCrudTest extends TestCase implements ICrudTest
{
    use DbTrait, CreatorDBTrait;

    private PoliticianCrud $politicianCrud;
    private PDO $pdo;
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PoliticianRepository $politicianRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicianRepository = new PoliticianRepository($this->pdo);
        $this->politicianCrud = new PoliticianCrud($this->pdo);
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

    public function testCreate()
    {
        $this->assertSame(0, $this->politicianRepository->count());
        $this->createPoliticianInDb("Michael Douglas");
        $this->assertSame(1, $this->politicianRepository->count());
    }

    public function testCreateId()
    {
        $newPolitician = (new Politician())
            ->setName("Partido Conservador da Nicarágua");
        $this->politicianCrud->create($newPolitician);
        $this->assertSame(1, $newPolitician->getId());
    }

    public function testRead()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $recoveredPolitician = $this->politicianCrud->read(1);
        $this->assertInstanceOf(Politician::class, $recoveredPolitician);
        $this->assertSame("Michael Douglas", $recoveredPolitician->getName());
    }

    public function testUpdate()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $this->politicianCrud->update(1, "Donald Trump");
        $recoveredPolitician = $this->politicianCrud->read(1);
        $this->assertSame("Donald Trump", $recoveredPolitician->getName());
    }

    public function testDelete()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $this->politicianCrud->delete(1);
        $this->assertSame(0, $this->politicianRepository->count());
    }
}
