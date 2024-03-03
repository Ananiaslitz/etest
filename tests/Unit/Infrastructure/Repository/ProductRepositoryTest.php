<?php

namespace Infrastructure\Repository;

use Core\Domain\Entity\ProductEntity;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Model\Product;
use Core\Infrastructure\Repository\ProductRepository;
use Mockery;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    private $modelMock;
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(Product::class);
        $this->repository = new ProductRepository($this->modelMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSaveCreatesOrUpdateProductAndReturnsId()
    {
        $this->modelMock->shouldReceive('updateOrCreate')
            ->once()
            ->andReturn((object)['id' => 1]);

        $productEntity = new ProductEntity(
            new IntegerIdValueObject(1),
            'Product Name',
            100.0,
            'Product Description'
        );

        $result = $this->repository->save($productEntity);

        $this->assertEquals(1, $result);
    }

    public function testFindByIdReturnsProductEntityOrNull()
    {
        $this->modelMock->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn((object)[
                'id' => 1,
                'name' => 'Product Name',
                'price' => 100.0,
                'description' => 'Product Description'
            ]);

        $result = $this->repository->findById(1);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertEquals(1, $result->getId()->getValue());

        $this->modelMock->shouldReceive('find')
            ->with(2)
            ->once()
            ->andReturnNull();

        $resultNotFound = $this->repository->findById(2);

        $this->assertNull($resultNotFound);
    }
}
