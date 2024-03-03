<?php

namespace Core\Infrastructure\Repository;

use Core\Domain\Entity\AbstractEntity;
use Core\Domain\Entity\ProductEntity;
use Core\Domain\Entity\SaleEntity;
use Core\Domain\Enum\SaleStatusEnum;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Domain\ValueObject\IntegerIdValueObject;
use Core\Infrastructure\Model\Sale;
use Illuminate\Support\Facades\DB;

class SaleRepository extends AbstractRepository implements SaleRepositoryInterface
{
    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }

//    public function getProductsBySaleId($saleId): ?SaleEntity
//    {
//        $saleModel = $this->model->with('products')->find($saleId);
//
//        if (!$saleModel) {
//            return null;
//        }
//
//        $saleEntity = new SaleEntity(/* Parâmetros necessários */);
//
//        foreach ($saleModel->products as $productModel) {
//            dd($productModel);
////            $productEntity = new ProductEntity(
////                $productModel->name,
////                $productModel->price,
////                $productModel->
////            );
////            $saleEntity->addProduct($productEntity);
//        }
//
//        return $saleEntity;
//    }

    /**
     * @throws \Exception
     */
    public function save(SaleEntity|AbstractEntity $entity): int
    {
        DB::beginTransaction();
        try {
            if ($entity->getId() && $entity->getId()->getId() !== null) {
                $sale = $this->model->find($entity->getId()->getId());
                if (!$sale) {
                    throw new \Exception("Sale not found.");
                }
            } else {
                $sale = new Sale();
            }

            $sale->created_at = $entity->getDate();
            $sale->amount = $entity->getTotalAmount();
            $sale->status = $entity->getStatus();
            $sale->save();

            foreach ($entity->getLineItems() as $item) {
                $sale->products()->attach(
                    $item['product']->getId(),
                    [
                        'amount' => $item['quantity'],
                        'created_at' => $entity->getDate()
                    ]
                );
            }

            DB::commit();

            return $sale->id;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById($saleId): ?SaleEntity
    {
        $saleModel = $this->model->with('products')->find($saleId);

        if (!$saleModel) {
            return null;
        }

        $saleEntity = new SaleEntity(
            new IntegerIdValueObject($saleModel->id),
            SaleStatusEnum::from($saleModel->status)
        );

        foreach ($saleModel->products as $productModel) {
            $productEntity = new ProductEntity(
                new IntegerIdValueObject($productModel->id),
                $productModel->name,
                $productModel->price,
                $productModel->description,
            );

            $saleEntity->addProduct($productEntity, $productModel->pivot->amount);
        }

        return $saleEntity;
    }
}
