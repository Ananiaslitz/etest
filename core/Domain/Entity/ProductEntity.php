<?php

namespace Core\Domain\Entity;

class ProductEntity extends AbstractEntity
{
    protected $name;
    protected $price;
    protected $description;

    /**
     * @param $name
     * @param $price
     * @param $description
     */
    public function __construct($name, $price, $description)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}
