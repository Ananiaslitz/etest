<?php

namespace Core\Domain\Entity;

use Core\Domain\ValueObject\IntegerIdValueObject;

abstract class AbstractEntity
{
    protected IntegerIdValueObject $id;

    public function __construct(IntegerIdValueObject $id)
    {
        $this->id = $id;
    }

    public function getId(): IntegerIdValueObject
    {
        return $this->id;
    }

    public function equals(AbstractEntity $otherEntity): bool
    {
        return $this->id->equals($otherEntity->getId());
    }
}
