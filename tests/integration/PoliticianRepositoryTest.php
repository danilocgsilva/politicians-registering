<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Danilocgsilva\PdoStringBuilder\Builder;
use Educacaopolitica\PoliticiansRegister\PoliticianRepository;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;

class PoliticianRepositoryTest extends TestCase
{
    private PoliticianRepository $repository;
    private Migrate $migrate;
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $pdoStringBuilder = (new Builder())
            ->setDbDns(getenv("DATABASE_DNS"))
            ->setDbName(getenv("DATABASE_NAME"));
        $this->pdo = new PDO($pdoStringBuilder->getPdoString(), getenv("DATABASE_USER"), getenv("DATABASE_PASSWORD"));
        $this->migrate = new Migrate($this->pdo);
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