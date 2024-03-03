<?php

namespace Application\Command\Sale;

use Core\Application\Command\Sale\AddProductToSaleCommand;
use Core\Domain\ValueObject\IntegerIdValueObject;
use PHPUnit\Framework\TestCase;

class AddProductToSaleCommandTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $saleId = new IntegerIdValueObject(1);
        $productId = new IntegerIdValueObject(2);
        $quantity = 5;

        $command = new AddProductToSaleCommand($saleId, $productId, $quantity);

        $this->assertSame($saleId, $command->getSaleId());
        $this->assertSame($productId, $command->getProductId());
        $this->assertSame($quantity, $command->getQuantity());
    }
}
