<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RepeatCostFactoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Persistence\ObjectManager;

class RepeatCostFixtures extends AbstractFixture
{
    public function __construct(
        private readonly RepeatCostFactoryInterface $repeatCostFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedRepeatCostFixture($manager);

        $manager->flush();
    }

    private function createFullyPopulatedRepeatCostFixture(ObjectManager $manager): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 2, day: 28)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        $fullyPopulatedRepeatCost = $this->repeatCostFactory->create(
            description: 'PhpStorm Annual License',
            cost: 15823,
            date: $date,
        );

        $manager->persist($fullyPopulatedRepeatCost);
    }
}
