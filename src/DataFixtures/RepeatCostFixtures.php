<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RepeatCostFactoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use LogicException;

class RepeatCostFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly RepeatCostFactoryInterface $repeatCostFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedRepeatCostFixture($manager);

        $manager->flush();
    }

    private function createFullyPopulatedRepeatCostFixture(ObjectManager $manager): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 2, day: 28)) {
            throw new LogicException(
                sprintf(
                    'Could not create instance of %s for %s, null return from %s',
                    CarbonImmutable::class,
                    'Date',
                    'CarbonImmutable::create',
                ),
            );
        }

        $fullyPopulatedRepeatCost = $this->repeatCostFactory->create(
            description: 'PhpStorm Annual License',
            cost: 15823,
            date: $date,
        );

        $manager->persist($fullyPopulatedRepeatCost);
    }
}
