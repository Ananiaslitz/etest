<?php

namespace Core\Domain\Enum;

enum SaleStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
