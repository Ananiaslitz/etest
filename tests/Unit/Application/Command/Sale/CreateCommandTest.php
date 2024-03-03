<?php

namespace Application\Command\Sale;

use PHPUnit\Framework\TestCase;
use Core\Application\Command\Sale\CreateCommand;

class CreateCommandTest extends TestCase
{
    public function testProductsAttribute()
    {
        $products = ['product1', 'product2', 'product3'];
        $createCommand = new CreateCommand($products);
        $this->assertSame($products, $createCommand->products);
    }
}
