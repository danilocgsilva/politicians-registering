<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Educacaopolitica\PoliticiansRegister\PoliticalParty;

class PoliticalPartyTest extends TestCase
{
    public function testFluentInterface()
    {
        $name = "Democratics";
        $id = 2;
        $politicalParty = (new PoliticalParty())
            ->setName($name)
            ->setId($id);

        $this->assertSame($name, $politicalParty->getName());
        $this->assertSame($id, $politicalParty->getId());
    }
}