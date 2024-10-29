<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RepeatCostFactoryInterface;
use App\Repository\RepeatCostRepositoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Persistence\ObjectManager;

class RepeatCostFixtures extends AbstractFixture
{
    public function __construct(
        private readonly RepeatCostFactoryInterface $factory,
        private readonly RepeatCostRepositoryInterface $repository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedRepeatCostFixture();
    }

    private function createFullyPopulatedRepeatCostFixture(): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 2, day: 28)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        $fullyPopulatedRepeatCost = $this->factory->create(
            description: 'PhpStorm Annual License',
            cost: 15823,
            date: $date,
        );

        $this->repository->save($fullyPopulatedRepeatCost);
    }
}
