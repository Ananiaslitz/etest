<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\AbstractEntity;
use Core\Domain\Entity\ProductEntity;

interface ProductRepositoryInterface
{
    public function save(ProductEntity|AbstractEntity $entity): int;
    public function findById($productId): ?ProductEntity;
}
