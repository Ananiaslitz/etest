<?php

namespace Domain\Entity;

use Core\Domain\Entity\SaleEntity;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Enum\SaleStatusEnum;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SaleEntityTest extends MockeryTestCase
{
    private $sale;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sale = new SaleEntity(new IntegerIdValueObject(null));
    }

    public function testAddProductAndCalculateTotal()
    {
        $product1Id = new IntegerIdValueObject(1);
        $product2Id = new IntegerIdValueObject(2);

        $product1 = Mockery::mock(ProductEntity::class);
        $product1->shouldReceive('getId')->andReturn($product1Id);
        $product1->shouldReceive('getPrice')->andReturn(100.00);

        $product2 = Mockery::mock(ProductEntity::class);
        $product2->shouldReceive('getId')->andReturn($product2Id);
        $product2->shouldReceive('getPrice')->andReturn(200.00);

        $sale = new SaleEntity(new IntegerIdValueObject(null));

        $sale->addProduct($product1, 2); // Total esperado: 200
        $this->assertEquals(200.00, $sale->getTotalAmount());

        $sale->addProduct($product2, 1); // Total esperado: 400
        $this->assertEquals(400.00, $sale->getTotalAmount());

        $sale->addProduct($product1, 1);
        $this->assertEquals(500.00, $sale->getTotalAmount());
    }


    public function testGetDate()
    {
        $this->assertInstanceOf(\DateTime::class, $this->sale->getDate());
    }

    public function testGetLineItems()
    {
        $product = Mockery::mock(ProductEntity::class);
        $product->shouldReceive('getId')->andReturn(1);
        $product->shouldReceive('getPrice')->andReturn(100.00);

        $this->sale->addProduct($product, 1);

        $lineItems = $this->sale->getLineItems();
        $this->assertCount(1, $lineItems);
        $this->assertEquals(1, $lineItems[0]['quantity']);
        $this->assertSame($product, $lineItems[0]['product']);
    }

    public function testCancelChangesStatusToCancelled()
    {
        $sale = new SaleEntity(new IntegerIdValueObject(1));
        $sale->cancel();

        $this->assertEquals(SaleStatusEnum::CANCELLED, $sale->getStatus());
    }

    public function testCompleteChangesStatusToCompleted()
    {
        $sale = new SaleEntity(new IntegerIdValueObject(1));
        $sale->complete();

        $this->assertEquals(SaleStatusEnum::COMPLETED, $sale->getStatus());
    }

    public function testCancelThrowsExceptionIfNotPending()
    {
        $this->expectException(\Exception::class);
        $sale = new SaleEntity(new IntegerIdValueObject(1), SaleStatusEnum::COMPLETED);
        $sale->cancel();
    }

    public function testCompleteThrowsExceptionIfNotPending()
    {
        $this->expectException(\Exception::class);
        $sale = new SaleEntity(new IntegerIdValueObject(1), SaleStatusEnum::CANCELLED);
        $sale->complete();
    }

    public function testToArrayReturnsCorrectArrayRepresentation()
    {
        $sale = new SaleEntity(new IntegerIdValueObject(1), SaleStatusEnum::PENDING);
        $date = $sale->getDate()->format('Y-m-d H:i:s');

        $product1 = new ProductEntity(
            new IntegerIdValueObject(1),
            'Product 1',
            100.0,
            'Description 1'
        );
        $product2 = new ProductEntity(
            new IntegerIdValueObject(2),
            'Product 2',
            50.0,
            'Description 2'
        );
        $sale->addProduct($product1, 2);
        $sale->addProduct($product2, 1);

        $expectedArray = [
            'date' => $date,
            'totalAmount' => 250.0,
            'lineItems' => [
                [
                    'productId' => 1,
                    'name' => 'Product 1',
                    'price' => 100.0,
                    'quantity' => 2,
                    'subtotal' => 200.0,
                ],
                [
                    'productId' => 2,
                    'name' => 'Product 2',
                    'price' => 50.0,
                    'quantity' => 1,
                    'subtotal' => 50.0,
                ]
            ],
        ];

        $this->assertEquals($expectedArray, $sale->toArray());
    }

    public function testAddProductThrowsExceptionWhenSaleIsNotPending()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Sale is not in a PENDING status.");

        $sale = new SaleEntity(
            new IntegerIdValueObject(1),
            SaleStatusEnum::COMPLETED
        );
        $product = new ProductEntity(
            new IntegerIdValueObject(1),
            'Product 1',
            100.0,
            'Description 1'
        );

        $sale->addProduct($product, 1);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
