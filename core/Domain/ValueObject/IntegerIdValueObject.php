<?php

namespace Core\Domain\ValueObject;

class IntegerIdValueObject extends AbstractValueObject
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("ID deve ser um valor positivo.");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    protected function getAttributes(): array
    {
        return ['value' => $this->value];
    }
}
