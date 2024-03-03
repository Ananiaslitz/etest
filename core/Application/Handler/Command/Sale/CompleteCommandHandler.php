<?php

namespace Core\Application\Handler\Command\Sale;

use Core\Application\Command\Sale\CancelCommand;
use Core\Application\Command\Sale\CompleteCommand;
use Core\Domain\Repository\SaleRepositoryInterface;

class CompleteCommandHandler
{
    private $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * @throws \Exception
     */
    public function handle(CompleteCommand $command): void
    {
        $saleId = $command->getSaleId()->getId();

        $sale = $this->saleRepository->findById($saleId);

        if (!$sale) {
            throw new \Exception('Sale not found', 404);
        }

        $sale->complete();

        $this->saleRepository->save($sale);
    }
}
