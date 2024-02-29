<?php

namespace Core\Domain\Entity;

class SaleEntity extends AbstractEntity
{
    private $date;
    private $totalAmount = 0;
    private $lineItems = [];

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function addProduct(ProductEntity $product, int $quantity)
    {
        foreach ($this->lineItems as &$item) {
            if ($item['product']->getId() === $product->getId()) {
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

    public function getDate() { return $this->date; }
    public function getTotalAmount() { return $this->totalAmount; }
    public function getLineItems() { return $this->lineItems; }
}
