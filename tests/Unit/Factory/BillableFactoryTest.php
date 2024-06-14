<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Address;
use App\Entity\Billable;
use App\Entity\Company;
use App\Entity\Const\Billable as BillableConstants;
use App\Entity\Const\Company as CompanyConstants;
use App\Entity\Invoice;
use App\Exception\EntityFactoryValidationException;
use App\Factory\BillableFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BillableFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private BillableFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new BillableFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $date = CarbonImmutable::parse('2023-02-23');
        $type = BillableConstants::TYPE_FULL_DAY;
        $rate = 25000;
        $subjectToVat = false;

        $client = (new Company())
            ->setName('Lanentech')
            ->setIdent('lanentech')
            ->setType(CompanyConstants::TYPE_BUSINESS)
            ->setCompanyNumber(12345678)
            ->setAddress(
                (new Address())
                    ->setHouseNumber('3')
                    ->setStreet('Tarkov Street')
                    ->setTownCity('Liverpool')
                    ->setPostcode('LV1 0OL')
                    ->setCountry('GBR')
            );

        $invoice = (new Invoice())
            ->setIdent('invoice-02-28-2024-tcil')
            ->setNumber('LT0061')
            ->setDate(CarbonImmutable::parse('2023-02-23'))
            ->setPaymentDueDate(CarbonImmutable::parse('2023-03-23'))
            ->setAgencyInvoiceNumber('98866');

        $agency = (new Company())
            ->setName('Agents R Us')
            ->setIdent('agents-r-us')
            ->setType(CompanyConstants::TYPE_AGENCY)
            ->setCompanyNumber(78912365)
            ->setAddress(
                (new Address())
                    ->setHouseNumber('23a')
                    ->setStreet('Podrick Avenue')
                    ->setTownCity('Chester')
                    ->setPostcode('C12 4KM')
                    ->setCountry('GBR')
            );

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($date, $type, $rate, $subjectToVat, $client, $invoice, $agency);

        $this->assertInstanceOf(Billable::class, $result);
        $this->assertEquals($date, $result->getDate());
        $this->assertEquals($type, $result->getType());
        $this->assertEquals($rate, $result->getRate());
        $this->assertEquals($subjectToVat, $result->isSubjectToVat());
        $this->assertEquals($client, $result->getClient());
        $this->assertEquals($invoice, $result->getInvoice());
        $this->assertEquals($agency, $result->getAgency());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $date = CarbonImmutable::parse('2023-02-23');
        $type = 'Invalid Type';
        $rate = 25000;
        $subjectToVat = false;

        $client = (new Company())
            ->setName('Lanentech')
            ->setIdent('lanentech')
            ->setType(CompanyConstants::TYPE_BUSINESS)
            ->setCompanyNumber(12345678)
            ->setAddress(
                (new Address())
                    ->setHouseNumber('3')
                    ->setStreet('Tarkov Street')
                    ->setTownCity('Liverpool')
                    ->setPostcode('LV1 0OL')
                    ->setCountry('GBR')
            );

        $invoice = (new Invoice())
            ->setIdent('invoice-02-28-2024-tcil')
            ->setNumber('LT0061')
            ->setDate(CarbonImmutable::parse('2023-02-23'))
            ->setPaymentDueDate(CarbonImmutable::parse('2023-03-23'))
            ->setAgencyInvoiceNumber('98866');

        $agency = (new Company())
            ->setName('Agents R Us')
            ->setIdent('agents-r-us')
            ->setType(CompanyConstants::TYPE_AGENCY)
            ->setCompanyNumber(78912365)
            ->setAddress(
                (new Address())
                    ->setHouseNumber('23a')
                    ->setStreet('Podrick Avenue')
                    ->setTownCity('Chester')
                    ->setPostcode('C12 4KM')
                    ->setCountry('GBR')
            );

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn(
            sprintf('Type invalid. Must be one of: %s', implode(',', BillableConstants::TYPES)),
        );

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($billable), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($date, $type, $rate, $subjectToVat, $client, $invoice, $agency);
    }
}
