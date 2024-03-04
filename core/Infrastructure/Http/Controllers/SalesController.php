<?php

namespace Core\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\Application\Command\Sale\AddProductToSaleCommand;
use Core\Application\Command\Sale\CancelCommand;
use Core\Application\Command\Sale\CompleteCommand;
use Core\Application\Command\Sale\CreateCommand;
use Core\Application\CommandQueryBusInterface;
use Core\Application\Query\FindAllSalesQuery;
use Core\Application\Query\FindSaleByIdQuery;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Http\Request\AddProductToSaleRequest;
use Core\Infrastructure\Http\Request\CreateSaleRequest;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class SalesController extends Controller
{
    private $commandBus;

    public function __construct(CommandQueryBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @OA\Get(
     *     path="/api/sales",
     *     operationId="getSalesList",
     *     tags={"Sales"},
     *     summary="Get list of sales",
     *     description="Returns a list of sales with details including products sold in each sale",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Sale ID"),
     *                 @OA\Property(property="amount", type="string", description="Total amount of the sale"),
     *                 @OA\Property(property="status", type="string", description="Status of the sale"),
     *                 @OA\Property(property="created_at", type="string", description="Creation date of the sale"),
     *                 @OA\Property(property="updated_at", type="string", description="Last update date of the sale"),
     *                 @OA\Property(
     *                     property="products",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Product ID"),
     *                         @OA\Property(property="name", type="string", description="Product name"),
     *                         @OA\Property(property="price", type="string", description="Product price"),
     *                         @OA\Property(property="description", type="string", description="Product description"),
     *                         @OA\Property(
     *                             property="pivot",
     *                             type="object",
     *                             @OA\Property(property="sale_id", type="integer",
     *     description="Sale ID associated with the product"),
     *                             @OA\Property(property="product_id", type="integer", description="Product ID"),
     *                             @OA\Property(property="amount", type="integer",
     *     description="Quantity of the product sold")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $query = new FindAllSalesQuery();

        $sales = $this->commandBus->dispatch($query);

        return response()->json($sales, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/sales",
     *     operationId="createSale",
     *     tags={"Sales"},
     *     summary="Record a new sale",
     *     description="Records a new sale with one or more products",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Payload to create a new sale",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="productId", type="string",
     *      description="ID of the product", example="1"),
     *                     @OA\Property(property="quantity", type="integer",
     *     description="Quantity of the product", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale recorded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Sale recorded successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(CreateSaleRequest $request)
    {
        $products = $request->get('products');

        $command = new CreateCommand($products);

        try {
            $saleId = $this->commandBus->dispatch($command);

            return response()->json('', Response::HTTP_CREATED)
                ->header('Location', route('sales.show', ['id' => $saleId]));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to create sale'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/sales/{id}",
     *     operationId="getSaleById",
     *     tags={"Sales"},
     *     summary="Get sale details by ID",
     *     description="Returns details of a specific sale including products sold",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of sale to return",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="Sale ID"),
     *             @OA\Property(property="amount", type="string", description="Total amount of the sale"),
     *             @OA\Property(property="created_at", type="string", description="Creation date of the sale"),
     *             @OA\Property(property="updated_at", type="string", description="Last update date of the sale"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="Product ID"),
     *                     @OA\Property(property="name", type="string", description="Product name"),
     *                     @OA\Property(property="price", type="string", description="Product price"),
     *                     @OA\Property(property="description", type="string", description="Product description"),
     *                     @OA\Property(
     *                         property="pivot",
     *                         type="object",
     *                         @OA\Property(property="sale_id", type="integer", description="Sale ID"),
     *                         @OA\Property(property="product_id", type="integer", description="Product ID"),
     *                         @OA\Property(property="amount", type="integer",
     *     description="Quantity of the product sold in this sale")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found"
     *     )
     * )
     */
    public function show($id)
    {
        $query = new FindSaleByIdQuery($id);

        try {
            $sale = $this->commandBus->dispatch($query);
            return response()->json($sale);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/sales/{id}/cancel",
     *     operationId="cancelSale",
     *     tags={"Sales"},
     *     summary="Cancel a sale",
     *     description="Cancels a sale. A sale can only be
     * marked as cancelled if it is currently in the pending state.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale to be cancelled",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale cancelled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sale cancelled successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string",
     *     example="A sale can only be marked as cancel if it is currently in the pending state.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found"
     *     )
     * )
     */
    public function cancel($id)
    {
        $saleId = new IntegerIdValueObject($id);
        $command = new CancelCommand($saleId);

        try {
            $this->commandBus->dispatch($command);
            return response()->json(['message' => 'Sale cancelled successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/sales/{id}/complete",
     *     operationId="completeSale",
     *     tags={"Sales"},
     *     summary="Mark a sale as complete",
     *     description="Marks a sale as complete. A sale can only be marked
     * as complete if it is currently in the pending state.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale to mark as complete",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale marked as complete successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sale marked as complete successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string",
     *      example="A sale can only be marked as complete if it is currently in the pending state.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found"
     *     )
     * )
     */
    public function complete($id)
    {
        $saleId = new IntegerIdValueObject($id);
        $command = new CompleteCommand($saleId);

        try {
            $this->commandBus->dispatch($command);
            return response()->json(['message' => 'Sale completed successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/sales/{id}/add-product",
     *     operationId="addProductToSale",
     *     tags={"Sales"},
     *     summary="Add a product to a sale",
     *     description="Adds a product to an existing sale by specifying the product ID and quantity.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale to add the product to",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product ID and quantity to add to the sale",
     *         @OA\JsonContent(
     *             required={"productId", "quantity"},
     *             @OA\Property(property="productId", type="string", description="ID of the product to add"),
     *             @OA\Property(property="quantity", type="string", description="Quantity of the product to add")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product added to sale successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product added to sale successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Error message in case of failure")
     *         )
     *     )
     * )
     */
    public function addProduct(AddProductToSaleRequest $request, $id)
    {
        $saleId = new IntegerIdValueObject((int) $id);
        $productId = new IntegerIdValueObject($request->productId);
        $quantity = $request->quantity;

        $command = new AddProductToSaleCommand($saleId, $productId, $quantity);

        try {
            $this->commandBus->dispatch($command);
            return response()->json(['message' => 'Product added to sale successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
