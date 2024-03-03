<?php

namespace Application\Handler\Query;

use PHPUnit\Framework\TestCase;
use Core\Application\Handler\Query\GetAllProductsQueryHandler;
use Core\Application\Query\GetAllProductsQuery;
use Core\Infrastructure\Model\Product;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class GetAllProductsQueryHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandle()
    {
        $productMock = \Mockery::mock(Product::class);

        $productMock->shouldReceive('paginate')
            ->with(10, ['*'], 'page', 1)
            ->andReturn(['product1', 'product2', 'product3']);

        $handler = new GetAllProductsQueryHandler($productMock);

        $query = new GetAllProductsQuery(10, 1);

        $result = $handler->handle($query);

        $this->assertEquals(['product1', 'product2', 'product3'], $result);
    }
}
