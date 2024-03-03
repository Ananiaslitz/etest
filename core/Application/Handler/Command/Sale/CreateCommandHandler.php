<?php

namespace Core\Application\Handler\Command\Sale;

use Core\Application\Command\Sale\CreateCommand;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Repository\ProductRepository;
use Core\Infrastructure\Repository\SaleRepository;

class CreateCommandHandler
{
    private $productRepository;
    private $saleRepository;

    public function __construct(ProductRepository $productRepository, SaleRepository $saleRepository)
    {
        $this->productRepository = $productRepository;
        $this->saleRepository = $saleRepository;
    }

    public function handle(CreateCommand $command)
    {
        $sale = new SaleEntity(new IntegerIdValueObject(null));

        foreach ($command->products as $productData) {
            $product = $this->productRepository->findById($productData['productId']);
            if ($product) {
                $sale->addProduct($product, $productData['quantity']);
            }
        }

        $sale = $this->saleRepository->save($sale);

        return $sale;
    }
}
