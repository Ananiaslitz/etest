<?php

namespace Application\Handler\Command;

use Core\Application\Command\Sale\CreateCommand;
use Core\Application\Handler\Command\Sale\CreateCommandHandler;
use Core\Domain\Entity\Product;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Entity\SaleEntity;
use Core\Infrastructure\Repository\ProductRepository;
use Core\Infrastructure\Repository\SaleRepository;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateCommandHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleCreatesSaleAndAddsProducts()
    {
        $productData = [
            ['productId' => 1, 'quantity' => 2],
            ['productId' => 2, 'quantity' => 3]
        ];

        $command = new CreateCommand($productData);

        $mockProductRepository = Mockery::mock(ProductRepository::class);
        $mockSaleRepository = Mockery::mock(SaleRepository::class);

        foreach ($productData as $data) {
            $mockProduct = Mockery::mock(ProductEntity::class);
            $mockProductRepository->shouldReceive('findById')
                ->with($data['productId'])
                ->andReturn($mockProduct);

            $mockProduct->shouldReceive('getId')
                ->times(2)
                ->andReturn(new IntegerIdValueObject($data['productId']));

            $mockProduct->shouldReceive('getPrice')
                ->andReturn(100.00);
        }

        $mockSaleRepository->shouldReceive('save')
            ->once()
            ->andReturn((new IntegerIdValueObject(1))->getId());

        $handler = new CreateCommandHandler($mockProductRepository, $mockSaleRepository);

        $resultSale = $handler->handle($command);

        $this->assertIsInt($resultSale);
    }
}
