<?php

namespace Application\Command\Sale;

use PHPUnit\Framework\TestCase;
use Core\Application\Command\Sale\CompleteCommand;
use Core\Domain\ValueObject\IntegerIdValueObject;

class CompleteCommandTest extends TestCase
{
    public function testGetSaleId()
    {
        $saleId = new IntegerIdValueObject(123);
        $completeCommand = new CompleteCommand($saleId);
        $this->assertSame($saleId, $completeCommand->getSaleId());
    }
}
