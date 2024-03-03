<?php

namespace Core\Application\Command\Sale;

use Core\Domain\ValueObject\IntegerIdValueObject;

class AddProductToSaleCommand
{
    private IntegerIdValueObject $saleId;
    private IntegerIdValueObject $productId;
    private int $quantity;

    public function __construct(IntegerIdValueObject $saleId, IntegerIdValueObject $productId, int $quantity)
    {
        $this->saleId = $saleId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getSaleId(): IntegerIdValueObject
    {
        return $this->saleId;
    }

    public function getProductId(): IntegerIdValueObject
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

}
