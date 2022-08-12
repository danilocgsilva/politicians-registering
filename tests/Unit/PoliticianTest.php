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

    public function testGetDefaultPhotoCount()
    {
        $politician = new Politician();
        $this->assertCount(0, $politician->getPhotos());
    }
    
    public function testGetAddPhoto()
    {
        $politician = new Politician();
        $photoPath = "/var/www/html/public/photos/CristinaKirchner01.jpg";
        $politician->addPhoto($photoPath);
        $this->assertCount(1, $politician->getPhotos());
    }

    public function testGetAddSeveralPhotos()
    {
        $politician = new Politician();
        
        $firstPath = "/var/www/html/public/files/GBoric1.jpg";
        $secondPath = "/var/www/html/public/files/GBoric2.png";

        $politician->addPhoto($firstPath);
        $politician->addPhoto($secondPath);

        $this->assertCount(2, $politician->getPhotos());
    }
}