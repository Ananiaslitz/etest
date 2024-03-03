<?php

namespace Core\Application\Handler\Command\Sale;

use Core\Application\Query\FindAllSalesQuery;
use Core\Infrastructure\Model\Sale;

class FindAllSalesHandler
{
    public function __construct(private Sale $sale)
    {
    }

    public function handle(FindAllSalesQuery $query)
    {
        $sales = $this->sale->with('products')->get();

        return $sales->map(
            function ($sale) {
                return $sale->toArray();
            }
        );
    }
}
