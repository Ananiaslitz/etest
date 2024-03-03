<?php

namespace Core\Application\Query;

class GetAllProductsQuery implements QueryInterface
{
    public $perPage;
    public $page;

    public function __construct($perPage = 15, $page = null)
    {
        $this->perPage = $perPage;
        $this->page = $page ?: request()->input('page', 1);
    }
}
