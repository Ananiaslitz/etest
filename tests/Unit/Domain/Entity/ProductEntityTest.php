<?php

namespace Domain\Entity;

use Core\Domain\Entity\ProductEntity;
use Core\Domain\ValueObject\IntegerIdValueObject;
use PHPUnit\Framework\TestCase;

class ProductEntityTest extends TestCase
{
    public function testProductEntityGetters()
    {
        $id = new IntegerIdValueObject(1);
        $name = 'Product Name';
        $price = 99.99;
        $description = 'Product Description';

        $product = new ProductEntity($id, $name, $price, $description);

        $this->assertEquals($id, $product->getId());
        $this->assertSame($name, $product->getName());
        $this->assertSame($price, $product->getPrice());
        $this->assertSame($description, $product->getDescription());
    }

    public function testProductEntityToArray()
    {
        $id = new IntegerIdValueObject(1);
        $name = 'Product Name';
        $price = 99.99;
        $description = 'Product Description';

        $product = new ProductEntity($id, $name, $price, $description);

        $expectedArray = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
        ];

        $this->assertEquals($expectedArray, $product->toArray());
    }
}
