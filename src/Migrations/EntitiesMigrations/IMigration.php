<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations\EntitiesMigrations;

interface IMigration
{
    public function getQueryCreation(): string;
}
