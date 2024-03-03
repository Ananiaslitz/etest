<?php

namespace Core\Domain\Entity;

use Core\Domain\ValueObject\IntegerIdValueObject;

class ProductEntity extends AbstractEntity
{
    protected $name;
    protected $price;
    protected $description;

    public function __construct(IntegerIdValueObject $id, string $name, float $price, string $description)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getId(): IntegerIdValueObject
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}
