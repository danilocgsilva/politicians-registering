<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use PDO;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;

class PoliticianRepositoryTest extends TestCase
{
    use DbTrait;
    
    private PoliticianRepository $repository;
    private Migrate $migrate;
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->repository = new PoliticianRepository($this->pdo);
    }

    public function setUp(): void
    {
        $this->migrate->migrate();
    }

    public function tearDown(): void
    {
        $this->migrate->undoMigrate();
    }

    public function testRepositoryCount()
    {
        $this->assertSame(0, $this->repository->count());
    }
}