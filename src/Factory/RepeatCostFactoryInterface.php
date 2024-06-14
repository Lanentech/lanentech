<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\RepeatCost;
use Carbon\CarbonImmutable;

interface RepeatCostFactoryInterface
{
    public function create(
        string $description,
        int $cost,
        CarbonImmutable $date,
    ): RepeatCost;
}
