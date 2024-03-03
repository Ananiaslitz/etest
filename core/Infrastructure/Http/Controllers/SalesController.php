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

class SalesController extends Controller
{
    private $commandBus;

    public function __construct(CommandQueryBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function index()
    {
        $query = new FindAllSalesQuery();

        $sales = $this->commandBus->dispatch($query);

        return response()->json($sales, Response::HTTP_OK);
    }

    public function store(CreateSaleRequest $request)
    {
        $products = $request->get('products');

        $command = new CreateCommand($products);

        try {
            $saleId = $this->commandBus->dispatch($command);

            return response()->json('', Response::HTTP_CREATED)
                ->header('Location', route('sales.show', ['id' => $saleId]));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => 'Unable to create sale'], Response::HTTP_BAD_REQUEST);
        }
    }

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
