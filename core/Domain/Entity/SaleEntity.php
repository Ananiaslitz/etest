<?php

namespace Core\Domain\Entity;

use Core\Domain\Contracts\ToArray;
use Core\Domain\Enum\SaleStatusEnum;
use Core\Domain\ValueObject\IntegerIdValueObject;

class SaleEntity extends AbstractEntity implements ToArray
{
    private $date;
    private $totalAmount = 0;
    private SaleStatusEnum $status;

    private $lineItems = [];

    public function __construct(IntegerIdValueObject $id, SaleStatusEnum $status = SaleStatusEnum::PENDING)
    {
        parent::__construct($id);
        $this->date = new \DateTime();
        $this->status = $status;
    }

    public function addProduct(ProductEntity $product, int $quantity)
    {
        if ($this->status !== SaleStatusEnum::PENDING) {
            throw new \Exception("Sale is not in a PENDING status.");
        }

        foreach ($this->lineItems as &$item) {
            if (
                $item['product']->getId()
                && $product->getId()
                && $item['product']->getId()->equals($product->getId())
            ) {
                $item['quantity'] += $quantity;
                $this->calculateTotal();
                return;
            }
        }

        $this->lineItems[] = ['product' => $product, 'quantity' => $quantity];
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalAmount = 0;

        foreach ($this->lineItems as $item) {
            $this->totalAmount += $item['product']->getPrice() * $item['quantity'];
        }
    }

    public function cancel(): void
    {
        if ($this->status !== SaleStatusEnum::PENDING) {
            throw new \Exception(
                'A sale can only be marked as cancel if it is currently in the pending state.',
                422
            );
        }

        $this->setStatus(SaleStatusEnum::CANCELLED);
    }

    public function complete(): void
    {
        if ($this->status !== SaleStatusEnum::PENDING) {
            throw new \Exception(
                'A sale can only be marked as complete if it is currently in the pending state.',
                422
            );
        }


        $this->status = SaleStatusEnum::COMPLETED;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function getLineItems()
    {
        return $this->lineItems;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function toArray(): array
    {
        $lineItemsArray = [];

        foreach ($this->lineItems as $item) {
            $product = $item['product'];
            $lineItemsArray[] = [
                'productId' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => $item['quantity'],
                'subtotal' => $product->getPrice() * $item['quantity'],
            ];
        }

        return [
            'date' => $this->date->format('Y-m-d H:i:s'),
            'totalAmount' => $this->totalAmount,
            'lineItems' => $lineItemsArray,
        ];
    }

    private function setStatus(SaleStatusEnum $status): void
    {
        $this->status = $status;
    }
}
