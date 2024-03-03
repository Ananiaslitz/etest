<?php

namespace Infrastructure\Repository;

use Core\Domain\Entity\ProductEntity;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\Enum\SaleStatusEnum;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Model\Sale;
use Core\Infrastructure\Repository\SaleRepository;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class SaleRepositoryTest extends TestCase
{
    private $modelMock;
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(Sale::class);
        $this->repository = new SaleRepository($this->modelMock);

        DB::shouldReceive('beginTransaction')->andReturnNull();
        DB::shouldReceive('commit')->andReturnNull();
        DB::shouldReceive('rollBack')->andReturnNull();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSaveUpdatesExistingSaleWhenIdIsNotNull()
    {
        $this->modelMock->shouldReceive('setAttribute')->andReturnUsing(function ($key, $value) {
            $this->$key = $value;
        });
        $this->modelMock->shouldReceive('getAttribute')->andReturn(1);
        $this->modelMock->id = 1;
        $this->modelMock->shouldReceive('isIgnoringTimestamps')->andReturnSelf();
        $this->modelMock->shouldReceive('find')->with(1)->andReturn($this->modelMock);

        $this->modelMock->shouldReceive('save')->andReturn(true);

        $saleEntity = new SaleEntity(new IntegerIdValueObject(1), SaleStatusEnum::PENDING);
        $resultId = $this->repository->save($saleEntity);

        $this->assertEquals(1, $resultId);
    }

    public function testFindByIdReturnsSaleEntityOrNull()
    {
        // Mock para simular a busca com sucesso
        $this->modelMock->shouldReceive('with')->with('products')->andReturnSelf();
        $this->modelMock->shouldReceive('find')->with(1)->andReturn((object)[
            'id' => 1,
            'status' => 'pending',
            'products' => collect([
                (object)[
                    'id' => 1,
                    'name' => 'Product Name',
                    'price' => 100.00,
                    'description' => 'Product Description',
                    'pivot' => (object)['amount' => 2]
                ]
            ])
        ]);

        $result = $this->repository->findById(1);

        $this->assertInstanceOf(SaleEntity::class, $result);
        $this->assertEquals(1, $result->getId()->getId());
    }
}
