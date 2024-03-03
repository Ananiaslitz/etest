<?php

namespace Core\Application\Query;

class FindSaleByIdQuery
{
    public $saleId;

    public function __construct($saleId)
    {
        $this->saleId = $saleId;
    }
}
