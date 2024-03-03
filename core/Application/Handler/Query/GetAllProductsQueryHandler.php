<?php

namespace Core\Application\Handler\Query;

use Core\Application\Query\GetAllProductsQuery;
use Core\Infrastructure\Model\Product;

class GetAllProductsQueryHandler
{
    public function __construct(private Product $product)
    {
    }

    public function handle(GetAllProductsQuery $query)
    {
        return $this->product->paginate($query->perPage, ['*'], 'page', $query->page);
    }
}
