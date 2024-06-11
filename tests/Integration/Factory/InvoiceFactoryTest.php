<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\InvoiceFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;
use Carbon\CarbonImmutable;

class InvoiceFactoryTest extends IntegrationTestCase
{
    private InvoiceFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(InvoiceFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $ident = '';
        $number = str_repeat('123456', 100);
        $date = CarbonImmutable::parse('2023-02-23');
        $paymentDueDate = CarbonImmutable::parse('2023-03-23');
        $agencyInvoiceNumber = str_repeat('123456', 100);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Ident cannot be empty');
        $this->expectExceptionMessage('Number cannot be more than 255 characters');
        $this->expectExceptionMessage('Agency Invoice Number cannot be more than 255 characters');
        $this->sut->create($ident, $number, $date, $paymentDueDate, $agencyInvoiceNumber);
    }
}
