<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\RepeatCost;
use Carbon\CarbonImmutable;

readonly class RepeatCostFactory extends BaseFactory implements RepeatCostFactoryInterface
{
    public function createBlankObject(): RepeatCost
    {
        return new RepeatCost();
    }

    public function create(
        string $description,
        int $cost,
        CarbonImmutable $date,
    ): RepeatCost {
        $repeatCost = new RepeatCost();
        $repeatCost->setDescription($description);
        $repeatCost->setCost($cost);
        $repeatCost->setDate($date);

        $this->validateObject($repeatCost);

        return $repeatCost;
    }
}
