<?php

namespace Application\Handler\Command;

use Core\Application\Command\Product\CreateProductCommand;
use Core\Application\Handler\Command\Product\CreateProductCommandHandler;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Repository\ProductRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandleShouldCreateProductAndReturnId()
    {
        $expectedProductId = 1;

        $mockRepository = Mockery::mock(ProductRepositoryInterface::class);
        $mockRepository->shouldReceive('save')
            ->once()
            ->with(Mockery::type(ProductEntity::class))
            ->andReturn($expectedProductId);

        $command = new CreateProductCommand('Test Product', 100.0, 'Description of the product');

        $handler = new CreateProductCommandHandler($mockRepository);

        $result = $handler->handle($command);

        $this->assertEquals($expectedProductId, $result);
    }
}
