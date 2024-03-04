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

    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="getProductsList",
     *     tags={"Products"},
     *     summary="Get list of products",
     *     description="Returns list of products",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function getAll(Request $request)
    {
        $getAllProductsQuery = new GetAllProductsQuery($request->perPage);

        return response()->json($this->bus->dispatch($getAllProductsQuery));
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     operationId="addProduct",
     *     tags={"Products"},
     *     summary="Add a new product",
     *     description="Adds a new product to the system",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product object that needs to be added to the store",
     *         @OA\JsonContent(
     *             required={"name","price","description"},
     *             @OA\Property(property="name", type="string", example="Product X"),
     *             @OA\Property(property="price", type="number", format="float", example=10.0),
     *             @OA\Property(property="description", type="string", example="A new product description")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Product added successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
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
