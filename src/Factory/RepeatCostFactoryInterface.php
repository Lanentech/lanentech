<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\RepeatCost;
use Carbon\CarbonImmutable;

/**
 * @extends CanCreateBlankObjectInterface<RepeatCost>
 */
interface RepeatCostFactoryInterface extends CanCreateBlankObjectInterface
{
    public function create(
        string $description,
        int $cost,
        CarbonImmutable $date,
    ): RepeatCost;
}
