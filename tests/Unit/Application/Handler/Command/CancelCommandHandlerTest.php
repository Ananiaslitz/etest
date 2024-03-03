<?php

namespace Application\Handler\Command;

use Core\Application\Command\Sale\CancelCommand;
use Core\Application\Handler\Command\Sale\CancelCommandHandler;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Mockery;
use PHPUnit\Framework\TestCase;

class CancelCommandHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleCancelsSaleAndSavesIt()
    {
        $saleIdValueObject = new IntegerIdValueObject(1);

        $mockSale = Mockery::mock(SaleEntity::class);
        $mockSale->shouldReceive('cancel')->once();

        $mockSaleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $mockSaleRepository->shouldReceive('findById')
            ->with($saleIdValueObject->getId())
            ->once()
            ->andReturn($mockSale);
        $mockSaleRepository->shouldReceive('save')
            ->with($mockSale)
            ->once();

        $command = new CancelCommand($saleIdValueObject);
        $handler = new CancelCommandHandler($mockSaleRepository);

        $handler->handle($command);

        $this->assertTrue(true);
    }
}
