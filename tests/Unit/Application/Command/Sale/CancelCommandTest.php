<?php

namespace Application\Command\Sale;

use PHPUnit\Framework\TestCase;
use Core\Application\Command\Sale\CancelCommand;
use Core\Domain\ValueObject\IntegerIdValueObject;

class CancelCommandTest extends TestCase
{
    public function testGetSaleId()
    {
        $saleId = new IntegerIdValueObject(123);
        $cancelCommand = new CancelCommand($saleId);

        $this->assertSame($saleId, $cancelCommand->getSaleId());
    }
}
