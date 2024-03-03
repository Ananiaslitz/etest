<?php

namespace Core\Infrastructure\Repository;

use Core\Domain\Entity\AbstractEntity;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Model\Product;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function save(ProductEntity|AbstractEntity $entity): int
    {
        $productData = [
            'name' => $entity->getName(),
            'price' => $entity->getPrice(),
            'description' => $entity->getDescription(),
        ];

        $productModel = $this->model->updateOrCreate(['name' => $entity->getName()], $productData);

        return $productModel->id;
    }

    public function findById($productId): ?ProductEntity
    {
        $product = $this->model->find($productId);
        if (!$product) {
            return null;
        }

        return new ProductEntity(
            new IntegerIdValueObject($product->id),
            $product->name,
            $product->price,
            $product->description
        );
    }

}
