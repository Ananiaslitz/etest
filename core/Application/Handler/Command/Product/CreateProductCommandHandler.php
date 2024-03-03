<?php

namespace Core\Application\Handler\Command\Product;

use Core\Application\Command\Product\CreateProductCommand;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;

class CreateProductCommandHandler
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(CreateProductCommand $command)
    {
        $product = new ProductEntity(
            new IntegerIdValueObject(null),
            $command->name,
            $command->price,
            $command->description
        );

        return $this->productRepository->save($product);
    }
}
