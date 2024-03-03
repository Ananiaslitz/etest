<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\AbstractEntity;
use Core\Domain\Entity\SaleEntity;

interface SaleRepositoryInterface
{
    public function save(SaleEntity|AbstractEntity $entity): int;
    public function findById($productId): ?SaleEntity;
}
