<?php

namespace Core\Domain\ValueObject;

class IntegerIdValueObject extends AbstractValueObject
{
    private ?int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function equals(IntegerIdValueObject|AbstractValueObject $other): bool
    {
        return $this->id === $other->getId();
    }

    public function isInitialized(): bool
    {
        return $this->id !== null;
    }

    public function getValue(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function getAttributes(): array
    {
        return ['value' => $this->id];
    }
}
