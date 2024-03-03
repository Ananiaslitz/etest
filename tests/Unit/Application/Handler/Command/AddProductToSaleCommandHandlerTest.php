<?php

namespace Application\Handler\Command;

use Core\Application\Command\Sale\AddProductToSaleCommand;
use Core\Application\Handler\Command\Sale\AddProductToSaleCommandHandler;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Mockery;
use PHPUnit\Framework\TestCase;

class AddProductToSaleCommandHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleShouldAddProductToSale()
    {
        $saleId = new IntegerIdValueObject(1);
        $productId = new IntegerIdValueObject(2);

        $mockSaleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $mockSale = Mockery::mock(SaleEntity::class);
        $mockSaleRepository->shouldReceive('findById')
            ->with($saleId->getId())
            ->once()
            ->andReturn($mockSale);

        $mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $mockProduct = Mockery::mock(ProductEntity::class);
        $mockProductRepository->shouldReceive('findById')
            ->with($productId->getId())
            ->once()
            ->andReturn($mockProduct);

        $mockSale->shouldReceive('addProduct')
            ->with($mockProduct, 1)
            ->once();

        $mockSaleRepository->shouldReceive('save')
            ->with($mockSale)
            ->once();

        $command = new AddProductToSaleCommand($saleId, $productId, 1);
        $handler = new AddProductToSaleCommandHandler($mockSaleRepository, $mockProductRepository);

        $handler->handle($command);

        $this->assertTrue(true);
    }

    public function testHandleShouldThrowExceptionIfProductNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Product not found.");

        $saleId = new IntegerIdValueObject(1);
        $productId = new IntegerIdValueObject(2);

        $mockSaleRepository = Mockery::mock(SaleRepositoryInterface::class);
        $mockSale = Mockery::mock(SaleEntity::class);
        $mockSaleRepository->shouldReceive('findById')
            ->with($saleId->getId())
            ->andReturn($mockSale);

        $mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $mockProductRepository->shouldReceive('findById')
            ->with($productId->getId())
            ->andReturn(null);

        $command = new AddProductToSaleCommand($saleId, $productId, 1);
        $handler = new AddProductToSaleCommandHandler($mockSaleRepository, $mockProductRepository);

        $handler->handle($command);
    }
}
