<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Repositories\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use PDO;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;
use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;

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
}