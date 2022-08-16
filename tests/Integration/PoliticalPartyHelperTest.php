<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use Educacaopolitica\PoliticiansRegister\CRUD\{PoliticianCrud, PoliticalPartyCrud};
use Educacaopolitica\PoliticiansRegister\Tests\Traits\{DbTrait, CreatorDBTrait};
use Educacaopolitica\PoliticiansRegister\Migrations\{Migrate, UndoMigration};
use PDO;
use PHPUnit\Framework\TestCase;

class PoliticalPartyHelperTest extends TestCase
{
    use DbTrait, CreatorDBTrait;
    
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PDO $pdo;
    
    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->migrate = new Migrate($this->pdo);
        $this->politicianCrud = new PoliticianCrud($this->pdo);
        $this->politicalPartyCrud = new PoliticalPartyCrud($this->pdo);
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
        $this->createPoliticianInDb("Guilherme Boulos");
        $this->createPoliticalPartyInDb("PCO");
    }
}
