<?php

use Core\Application\Command\Product\CreateProductCommand;
use Core\Application\Command\Sale\AddProductToSaleCommand;
use Core\Application\Command\Sale\CancelCommand;
use Core\Application\Command\Sale\CompleteCommand;
use Core\Application\Command\Sale\CreateCommand;
use Core\Application\Handler\Command\Product\CreateProductCommandHandler;
use Core\Application\Handler\Command\Sale\AddProductToSaleCommandHandler;
use Core\Application\Handler\Command\Sale\CancelCommandHandler;
use Core\Application\Handler\Command\Sale\CancelHandler;
use Core\Application\Handler\Command\Sale\CompleteCommandHandler;
use Core\Application\Handler\Command\Sale\CreateCommandHandler;
use Core\Application\Handler\Query\FindAllSalesHandler;
use Core\Application\Handler\Query\FindSaleByIdCommandHandler;
use Core\Application\Handler\Query\GetAllProductsQueryHandler;
use Core\Application\Query\FindAllSalesQuery;
use Core\Application\Query\FindSaleByIdQuery;
use Core\Application\Query\GetAllProductsQuery;

return [
    'mappings' => array(
        GetAllProductsQuery::class =>  GetAllProductsQueryHandler::class,
        CreateProductCommand::class => CreateProductCommandHandler::class,

        //Sale
        CreateCommand::class => CreateCommandHandler::class,
        FindSaleByIdQuery::class => FindSaleByIdCommandHandler::class,
        FindAllSalesQuery::class => FindAllSalesHandler::class,
        CancelCommand::class => CancelCommandHandler::class,
        CompleteCommand::class => CompleteCommandHandler::class,
        AddProductToSaleCommand::class => AddProductToSaleCommandHandler::class
    ),
];
