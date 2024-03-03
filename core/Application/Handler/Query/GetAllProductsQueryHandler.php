<?php

namespace Core\Application\Handler\Query;

use Core\Application\Query\GetAllProductsQuery;
use Core\Infrastructure\Model\Product;

class GetAllProductsQueryHandler
{
    public function handle(GetAllProductsQuery $query)
    {
        return Product::paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
