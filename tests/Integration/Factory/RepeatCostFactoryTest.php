<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\RepeatCostFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;
use Carbon\CarbonImmutable;

class RepeatCostFactoryTest extends IntegrationTestCase
{
    private RepeatCostFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(RepeatCostFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $description = '';
        $cost = 1234567898526;
        $date = CarbonImmutable::parse('2023-02-23');

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Description cannot be empty');
        $this->expectExceptionMessage('Cost cannot be more than 10 digits');
        $this->sut->create($description, $cost, $date);
    }
}
