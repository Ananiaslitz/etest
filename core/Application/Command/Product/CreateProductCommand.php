<?php

namespace Core\Application\Command\Product;

class CreateProductCommand
{
    public $name;
    public $price;
    public $description;

    public function __construct($name, $price, $description)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}
