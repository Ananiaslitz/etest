<?php

namespace Core\Application\Handler\Query;

use Core\Application\Query\FindSaleByIdQuery;
use Core\Infrastructure\Model\Sale;

class FindSaleByIdCommandHandler
{
    public function __construct(private Sale $sale)
    {
    }

    public function handle(FindSaleByIdQuery $query)
    {
        $sale = $this->sale->with('products')->find($query->saleId);

        if (!$sale) {
            throw new \Exception('Sale not found');
        }

        return $sale;
    }
}
