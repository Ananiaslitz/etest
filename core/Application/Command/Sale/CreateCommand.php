<?php

namespace Core\Application\Command\Sale;

class CreateCommand
{
    public $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }
}
