<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration\Repositories;

use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;
use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticalPartyRepository;
use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\{DbTrait, CreatorDBTrait};
use PDO;
use DateTime;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticalPartyCrud;
use Educacaopolitica\PoliticiansRegister\CRUD\PoliticianCrud;
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticianRepository;

class PoliticalPartyRepositoryTest extends TestCase
{
    use DbTrait, CreatorDBTrait;

    private Migrate $migrate;
    private PDO $pdo;
    private PoliticalPartyRepository $politicalPartyRepository;
    private UndoMigration $undoMigration;
    private PoliticianCrud $politicianCrud;
    private PoliticalPartyCrud $politicalPartyCrud;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicalPartyRepository = new PoliticalPartyRepository($this->pdo);
        $this->undoMigration = new UndoMigration($this->pdo);
        $this->politicianCrud = new PoliticianCrud($this->pdo);
        $this->politicalPartyCrud = new PoliticalPartyCrud($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrateTable('politicians');
        $this->migrate->migrateTable('political_parties');
        $this->migrate->migrateTable('political_party_politician_pivot');
    }

    public function tearDown(): void
    {
        $this->undoMigration->deMigrateTable('political_party_politician_pivot');
        $this->undoMigration->deMigrateTable('political_parties');
        $this->undoMigration->deMigrateTable('politicians');
    }

    public function testAssignPoliticalParty()
    {
        $politician = $this->createPoliticianInDb("Guilherme Boulos");
        $politicalParty = $this->createPoliticalPartyInDb("PCO");
        $this->politicalPartyRepository->assignPoliticalParty(
            $politician, 
            $politicalParty,
            DateTime::createFromFormat('j-M-Y', '15-Feb-2009')
        );
        $politicianRepository = new PoliticianRepository($this->pdo);
        $politicianRepository->loadPoliticalParties($politician);
        $this->assertCount(1, $politician->getPoliticalPartiesHistory());
    }
}
