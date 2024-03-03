<?php

namespace Application\Command;

use PHPUnit\Framework\TestCase;
use Core\Application\Command\Product\CreateProductCommand;

class CreateProductCommandTest extends TestCase
{
    public function testCreateProductCommandProperties()
    {
        $name = 'Test Product';
        $price = 99.99;
        $description = 'Test Description';

        $command = new CreateProductCommand($name, $price, $description);

        $this->assertEquals($name, $command->name, 'Name was not set correctly');
        $this->assertEquals($price, $command->price, 'Price was not set correctly');
        $this->assertEquals($description, $command->description, 'Description was not set correctly');
    }
}
