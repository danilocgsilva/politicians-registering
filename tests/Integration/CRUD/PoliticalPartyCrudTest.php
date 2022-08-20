<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use Educacaopolitica\PoliticiansRegister\CRUD\PoliticalPartyCrud;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticalPartyRepository;
use Educacaopolitica\PoliticiansRegister\PoliticalParty;
use PHPUnit\Framework\TestCase;
use PDO;

class PoliticalPartyCrudTest extends TestCase implements ICrudTest
{
    use DbTrait;

    private PoliticalPartyCrud $crud;
    private PDO $pdo;
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PoliticalPartyRepository $politicalPartyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicalPartyRepository = new PoliticalPartyRepository($this->pdo);
        $this->crud = new PoliticalPartyCrud($this->pdo);
        $this->migrate = new Migrate($this->pdo);
        $this->undoMigration = new UndoMigration($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrateTable('politicians');
        $this->migrate->migrateTable('political_parties');
    }

    public function tearDown(): void
    {
        $this->undoMigration->deMigrateTable('political_parties');
        $this->undoMigration->deMigrateTable('politicians');
    }

    public function testCreate()
    {
        $this->assertSame(0, $this->politicalPartyRepository->count());
        $this->createPoliticalParty("Republicans");
        $this->assertSame(1, $this->politicalPartyRepository->count());
    }

    public function testCreateId()
    {
        $newPoliticalParty = (new PoliticalParty())
            ->setName("Partido Conservador Colombiano");
        $this->crud->create($newPoliticalParty);
        $this->assertSame(1, $newPoliticalParty->getId());
    }

    public function testRead()
    {
        $this->createPoliticalParty("Democrats");
        $recoveredPoliticalParty = $this->crud->read(1);
        $this->assertInstanceOf(PoliticalParty::class, $recoveredPoliticalParty);
        $this->assertSame("Democrats", $recoveredPoliticalParty->getName());
    }

    public function testUpdate()
    {
        $this->createPoliticalParty("Xiitas");
        $this->crud->update(1, "Sunita");
        $recoveredPoliticalParty = $this->crud->read(1);
        $this->assertSame("Sunita", $recoveredPoliticalParty->getName());
    }

    public function testDelete()
    {
        $this->createPoliticalParty("Partido do Novo Triunfo");
        $this->crud->delete(1);
        $this->assertSame(0, $this->politicalPartyRepository->count());
    }

    private function createPoliticalParty(string $name)
    {
        $newPoliticalParty = (new PoliticalParty())
            ->setName($name);
        $this->crud->create($newPoliticalParty);
    }
}
