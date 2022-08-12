<?php

namespace Educacaopolitica\PoliticiansRegister\Tests\Integration;

interface ICrudTest
{
    public function testRead();
    public function testUpdate();
    public function testDelete();
    public function testCreate();
}
