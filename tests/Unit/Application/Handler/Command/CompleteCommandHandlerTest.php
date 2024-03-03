<?php

namespace Application\Handler\Command;

use Core\Application\Command\Sale\CompleteCommand;
use Core\Application\Handler\Command\Sale\CompleteCommandHandler;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Mockery;
use PHPUnit\Framework\TestCase;

class CompleteCommandHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleCompletesSaleAndSavesIt()
    {
        $saleIdValueObject = new IntegerIdValueObject(1);

        $mockSale = Mockery::mock(SaleEntity::class);
        $mockSale->shouldReceive('complete')->once();

        $mockSaleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $mockSaleRepository->shouldReceive('findById')
            ->with($saleIdValueObject->getId())
            ->once()
            ->andReturn($mockSale);


        $mockSaleRepository->shouldReceive('save')
            ->with($mockSale)
            ->once();

        $command = new CompleteCommand($saleIdValueObject);
        $handler = new CompleteCommandHandler($mockSaleRepository);


        $this->assertEmpty($handler->handle($command));
    }

    public function testHandleThrowsExceptionWhenSaleNotFound()
    {
        $this->expectException(\Exception::class);

        $saleIdValueObject = new IntegerIdValueObject(999);

        $mockSaleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $mockSaleRepository->shouldReceive('findById')
            ->with($saleIdValueObject->getId())
            ->once()
            ->andReturn(null);

        $command = new CompleteCommand($saleIdValueObject);
        $handler = new CompleteCommandHandler($mockSaleRepository);

        $handler->handle($command);
    }

}
