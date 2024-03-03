<?php

namespace Core\Infrastructure\Http\Controllers;

use Core\Application\Command\Product\CreateProductCommand;
use Core\Application\CommandQueryBusInterface;
use Core\Application\Query\GetAllProductsQuery;
use Core\Infrastructure\Http\Request\CreateProductRequest;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    public function __construct(private CommandQueryBusInterface $bus)
    {
    }

    public function getAll(Request $request)
    {
        $getAllProductsQuery = new GetAllProductsQuery($request->perPage);

        return response()->json($this->bus->dispatch($getAllProductsQuery));
    }

    public function store(CreateProductRequest $request)
    {
        $command = new CreateProductCommand(
            $request->name,
            $request->price,
            $request->description
        );

        $productId = $this->bus->dispatch($command);

        return response()->json(['id' => $productId], 201)
            ->header('Location', url("/products/{$productId}"));
    }
}
