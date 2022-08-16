<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Tests\Traits;

use Educacaopolitica\PoliticiansRegister\PoliticalParty;
use Educacaopolitica\PoliticiansRegister\Politician;

trait CreatorDBTrait
{
    private function createPoliticianInDb(string $name)
    {
        $newPolitician = (new Politician())
            ->setName($name);
        $this->politicianCrud->create($newPolitician);
    }

    private function createPoliticalPartyInDb(string $name)
    {
        $newPoliticalParty = (new PoliticalParty())
            ->setName($name);
        $this->politicalPartyCrud->create($newPoliticalParty);
    }
}
