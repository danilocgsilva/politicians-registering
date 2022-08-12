<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

use Educacaopolitica\PoliticiansRegister\CRUD\PhotoCrud;
use ICrudTest;
use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Tests\Traits\DbTrait;
use PDO;
use Educacaopolitica\PoliticiansRegister\Migrations\UndoMigration;
use Educacaopolitica\PoliticiansRegister\Migrations\Migrate;
use PhotoRepository;

class PhotoCrudTest extends TestCase implements ICrudTest
{
    use DbTrait;

    private PhotoCrud $photoCrud;
    private PDO $pdo;
    private Migrate $migrate;
    private UndoMigration $undoMigration;
    private PhotoRepository $photoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->db();
        $this->
    }
}
