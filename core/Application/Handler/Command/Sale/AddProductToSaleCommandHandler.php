<?php

namespace Core\Application\Handler\Command\Sale;

use Core\Application\Command\Sale\AddProductToSaleCommand;
use Core\Domain\Enum\SaleStatusEnum;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Domain\Repository\ProductRepositoryInterface;

class AddProductToSaleCommandHandler
{
    public function __construct(
        private SaleRepositoryInterface $saleRepository,
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function handle(AddProductToSaleCommand $command): void
    {
        $sale = $this->saleRepository->findById($command->getSaleId()->getId());

        $product = $this->productRepository->findById($command->getProductId()->getId());

        if (!$product) {
            throw new \Exception("Product not found.");
        }

        $sale->addProduct($product, $command->getQuantity());

        $this->saleRepository->save($sale);
    }
}
