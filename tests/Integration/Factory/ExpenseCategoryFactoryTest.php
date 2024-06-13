<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\ExpenseCategoryFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;

class ExpenseCategoryFactoryTest extends IntegrationTestCase
{
    private ExpenseCategoryFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(ExpenseCategoryFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $name = str_repeat('Name', 100);
        $description = '';

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Name cannot be more than 255 characters');
        $this->expectExceptionMessage('Description cannot be empty');
        $this->sut->create($name, $description);
    }
}
