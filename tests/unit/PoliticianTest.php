<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\Politician;

class PoliticianTest extends TestCase
{
    public function testFluentInterface()
    {
        $name = "Joe Biden";
        $id = 12;
        $politician = (new Politician())
            ->setName($name)
            ->setId($id);

        $this->assertSame($name, $politician->getName());
        $this->assertSame($id, $politician->getId());
    }
}