<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\{CRUD, PoliticianRepository, Politician};
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;
use PDO;

class CRUDTest extends TestCase
{
    use DbTrait;

    private CRUD $crud;

    private PDO $pdo;

    private Migrate $migrate;

    private PoliticianRepository $politicianRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicianRepository = new PoliticianRepository($this->pdo);
        $this->crud = new CRUD($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrate();
    }

    public function tearDown(): void
    {
        $this->migrate->undoMigrate();
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