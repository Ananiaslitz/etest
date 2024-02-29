<?php

namespace Core\Domain\ValueObject;

class DateTimeValueObject extends AbstractValueObject
{
    private \DateTimeImmutable $value;

    /**
     * @throws \Exception
     */
    public function __construct(string $date)
    {
        $this->value = new \DateTimeImmutable($date);
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function isBefore(DateTimeValueObject $otherDate): bool
    {
        return $this->value < $otherDate->getValue();
    }

    public function isAfter(DateTimeValueObject $otherDate): bool
    {
        return $this->value > $otherDate->getValue();
    }

    public function __toString(): string
    {
        return $this->value->format('c');
    }

    protected function getAttributes(): array
    {
        return ['value' => $this->value->format('c')];
    }
}
