<?php

namespace Core\Domain\ValueObject;

abstract class AbstractValueObject
{
    public function equals(AbstractValueObject $other): bool
    {
        if (get_class($this) !== get_class($other)) {
            return false;
        }

        return $this->getAttributes() === $other->getAttributes();
    }

    abstract public function getAttributes(): array;
}
