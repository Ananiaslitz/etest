<?php

namespace Core\Application\Command\Sale;

use Core\Domain\ValueObject\IntegerIdValueObject;

class CompleteCommand
{
    private IntegerIdValueObject $saleId;

    public function __construct(IntegerIdValueObject $saleId)
    {
        $this->saleId = $saleId;
    }

    public function getSaleId(): IntegerIdValueObject
    {
        return $this->saleId;
    }
}
