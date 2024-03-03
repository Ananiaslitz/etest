<?php

namespace Application\Handler\Query;

use Mockery;
use PHPUnit\Framework\TestCase;
use Core\Application\Handler\Query\FindAllSalesHandler;
use Core\Application\Query\FindAllSalesQuery;
use Core\Infrastructure\Model\Sale;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Illuminate\Support\Collection;

class FindAllSalesHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandleReturnsExpectedSalesData()
    {
        $saleMock = Mockery::mock(Sale::class);
        $saleMock->shouldReceive('with')
            ->with('products')
            ->once()
            ->andReturnSelf();

        $expectedSalesData = [
            ['id' => 1, 'total' => 100, 'products' => ['product1', 'product2']],
            ['id' => 2, 'total' => 150, 'products' => ['product3', 'product4']],
        ];

        $salesCollection = new Collection();
        foreach ($expectedSalesData as $saleData) {
            $saleInstance = Mockery::mock(Sale::class);
            $saleInstance->shouldReceive('toArray')->andReturn([
                'id' => $saleData['id'],
                'total' => $saleData['total'], 'products' => $saleData['products']]);
            $salesCollection->push($saleInstance);
        }

        $saleMock->shouldReceive('get')
            ->once()
            ->andReturn($salesCollection);

        $handler = new FindAllSalesHandler($saleMock);

        $query = new FindAllSalesQuery();

        $result = $handler->handle($query);

        $this->assertInstanceOf(Collection::class, $result);
    }

}
