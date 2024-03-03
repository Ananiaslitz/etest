<?php

namespace Core\Application\Handler\Command\Sale;

use Core\Application\Command\Sale\CancelCommand;
use Core\Domain\Repository\SaleRepositoryInterface;

class CancelCommandHandler
{
    private $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function handle(CancelCommand $command): void
    {
        $saleId = $command->getSaleId()->getId();

        $sale = $this->saleRepository->findById($saleId);

        $sale->cancel();

        $this->saleRepository->save($sale);
    }
}
