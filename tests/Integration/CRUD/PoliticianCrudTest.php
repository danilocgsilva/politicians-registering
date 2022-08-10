<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Politician;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use PDO;

class PoliticianCrudTest extends TestCase
{
    use DbTrait;

    private PoliticianCrud $crud;

    private PDO $pdo;

    private Migrate $migrate;

    private UndoMigration $undoMigration;

    private PoliticianRepository $politicianRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicianRepository = new PoliticianRepository($this->pdo);
        $this->crud = new PoliticianCrud($this->pdo);
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

    public function testCreate()
    {
        $this->assertSame(0, $this->politicianRepository->count());
        $this->createPoliticianInDb("Michael Douglas");
        $this->assertSame(1, $this->politicianRepository->count());
    }

    public function testRead()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $recoveredPolitician = $this->crud->read(1);
        $this->assertInstanceOf(Politician::class, $recoveredPolitician);
        $this->assertSame("Michael Douglas", $recoveredPolitician->getName());
    }

    public function testUpdate()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $this->crud->update(1, "Donald Trump");
        $recoveredPolitician = $this->crud->read(1);
        $this->assertSame("Donald Trump", $recoveredPolitician->getName());
    }

    public function testDelete()
    {
        $this->createPoliticianInDb("Michael Douglas");
        $this->crud->delete(1);
        $this->assertSame(0, $this->politicianRepository->count());
    }

    private function createPoliticianInDb(string $name)
    {
        $newPolitician = (new Politician())
            ->setName($name);
        $this->crud->create($newPolitician);
    }
}