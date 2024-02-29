<?php

namespace Core\Infrastructure\Repository;

use Core\Infrastructure\Model\Sale;
use Illuminate\Database\Eloquent\Model;

class SaleRepository extends AbstractRepository
{
    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }

    public function getProductsBySaleId($saleId)
    {
        $sale = $this->model->with('products')->find($saleId);
        return $sale ? $sale->products : null;
    }
}
