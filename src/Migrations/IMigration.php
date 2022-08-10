<?php

declare(strict_types=1);

namespace Educacaopolitica\PoliticiansRegister\Migrations;

interface IMigration
{
    public function getQueryCreation(): string;
}
