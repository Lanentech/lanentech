<?php

declare(strict_types=1);

namespace App\Tests\Common\Seeder;

use App\Entity\RepeatCost;
use App\Factory\ExpenseFactoryInterface;
use Carbon\CarbonImmutable;

trait RepeatCostSeeder
{
    public function seedRepeatCost(array $overrides = []): RepeatCost
    {
        $repeatCostFactoryName = 'repeatCostFactory';

        $requiredProperties = [
            $repeatCostFactoryName => ExpenseFactoryInterface::class,
        ];

        foreach ($requiredProperties as $propertyName => $className) {
            if (!property_exists($this, $propertyName)) {
                $this->fail(
                    sprintf(
                        'To use the %s trait, you need to ensure you have injected the %s into your test class, ' .
                        'under a property called "%s".',
                        RepeatCostSeeder::class,
                        $className,
                        $propertyName,
                    ),
                );
            }
        }

        $repeatCost = $this->repeatCostFactory->create(
            description: $overrides['description'] ?? 'Fake Description',
            cost: $overrides['cost'] ?? 1529,
            date: $overrides['date'] ?? CarbonImmutable::now(),
        );

        $this->repeatCostRepository->save($repeatCost);

        return $repeatCost;
    }
}
