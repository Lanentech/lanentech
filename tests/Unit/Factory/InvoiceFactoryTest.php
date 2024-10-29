<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Invoice;
use App\Exception\EntityFactoryValidationException;
use App\Factory\InvoiceFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InvoiceFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private InvoiceFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new InvoiceFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $ident = 'invoice-02-28-2024-tcil';
        $number = 'LT0061';
        $date = CarbonImmutable::parse('2023-02-23');
        $paymentDueDate = CarbonImmutable::parse('2023-03-23');
        $agencyInvoiceNumber = '98866';

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($ident, $number, $date, $paymentDueDate, $agencyInvoiceNumber);

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertEquals($ident, $result->getIdent());
        $this->assertEquals($number, $result->getNumber());
        $this->assertEquals($date, $result->getDate());
        $this->assertEquals($paymentDueDate, $result->getPaymentDueDate());
        $this->assertEquals($agencyInvoiceNumber, $result->getAgencyInvoiceNumber());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $ident = '';
        $number = 'LT0061';
        $date = CarbonImmutable::parse('2023-02-23');
        $paymentDueDate = CarbonImmutable::parse('2023-03-23');
        $agencyInvoiceNumber = '98866';

        $violation = m::mock(ConstraintViolation::class);
        $violation->shouldReceive()->getMessage()->andReturn('Ident cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($invoice), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($ident, $number, $date, $paymentDueDate, $agencyInvoiceNumber);
    }
}
