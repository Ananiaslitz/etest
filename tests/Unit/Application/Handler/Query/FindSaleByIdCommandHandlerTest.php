<?php

namespace Application\Handler\Query;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Core\Application\Handler\Query\FindSaleByIdCommandHandler;
use Core\Application\Query\FindSaleByIdQuery;
use Core\Infrastructure\Model\Sale;

class FindSaleByIdCommandHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandleReturnsSaleWhenFound()
    {
        $saleModelMock = Mockery::mock(Sale::class);
        $saleId = 1;
        $saleData = new Sale(['id' => $saleId, 'total' => 100, 'products' => []]);

        $saleModelMock->shouldReceive('with')
            ->with('products')
            ->once()
            ->andReturnSelf();
        $saleModelMock->shouldReceive('find')
            ->with($saleId)
            ->once()
            ->andReturn($saleData);

        $handler = new FindSaleByIdCommandHandler($saleModelMock);
        $query = new FindSaleByIdQuery($saleId);

        $result = $handler->handle($query);

        $this->assertSame($saleData, $result);
    }

    public function testHandleThrowsExceptionWhenSaleNotFound()
    {
        $saleModelMock = Mockery::mock(Sale::class);
        $saleId = 99;

        $saleModelMock->shouldReceive('with')
            ->with('products')
            ->once()
            ->andReturnSelf();
        $saleModelMock->shouldReceive('find')
            ->with($saleId)
            ->once()
            ->andReturnNull();

        $handler = new FindSaleByIdCommandHandler($saleModelMock);
        $query = new FindSaleByIdQuery($saleId);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Sale not found');

        $handler->handle($query);
    }
}
