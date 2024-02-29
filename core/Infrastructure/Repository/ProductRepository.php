<?php

namespace Core\Infrastructure\Repository;

use Core\Infrastructure\Model\Product;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends AbstractRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
