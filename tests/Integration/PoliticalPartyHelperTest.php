<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use Educacaopolitica\PoliticiansRegister\CRUD\{PoliticianCrud, PoliticalPartyCrud};
use Educacaopolitica\PoliticiansRegister\Helpers\PoliticalPartyHelper;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\{DbTrait, CreatorDBTrait};
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use PDO;
use PHPUnit\Framework\TestCase;
use DateTime;

class PoliticalPartyHelperTest extends TestCase
{
    use DbTrait, CreatorDBTrait;
    
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PDO $pdo;
    private PoliticalPartyCrud $politicalPartyCrud;
    private PoliticianCrud $politicianCrud;
    
    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->politicianCrud = new PoliticianCrud($this->pdo);
        $this->politicalPartyCrud = new PoliticalPartyCrud($this->pdo);
        $this->migrate = new Migrate($this->pdo);
        $this->undoMigration = new UndoMigration($this->pdo);
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
    
    public function testAssignPoliticalPartyToPolitician()
    {
        $politician = $this->createPoliticianInDb("Guilherme Boulos");
        $politicalParty = $this->createPoliticalPartyInDb("PCO");
        $politicalPartyHelper = new PoliticalPartyHelper($this->pdo);
        $politicalPartyHelper->assignPoliticalParty(
            $politician, 
            $politicalParty,
            DateTime::createFromFormat('j-M-Y', '15-Feb-2009')
        );
        $politician->loadPoliticalParties($this->pdo);
        $this->assertCount(1, $politician->getPoliticalPartiesHistory());
    }
}
