<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use LogicException;

abstract class AbstractFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    protected function throwExceptionWhenDateCannotBeCreated(string $key): never
    {
        throw new LogicException(
            sprintf(
                'Could not create instance of %s for %s, null return from %s',
                CarbonImmutable::class,
                $key,
                'CarbonImmutable::create',
            ),
        );
    }
}
