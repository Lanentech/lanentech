<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\Const\Billable as BillableConstants;
use App\Entity\Const\Company as CompanyConstants;
use App\Entity\Invoice;
use App\Exception\EntityFactoryValidationException;
use App\Factory\BillableFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;
use Carbon\CarbonImmutable;

class BillableFactoryTest extends IntegrationTestCase
{
    private BillableFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(BillableFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $date = CarbonImmutable::parse('2023-02-23');
        $type = 'Invalid Type';
        $rate = 123456789123456789;
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

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage(
            sprintf('Type invalid. Must be one of: %s', implode(',', BillableConstants::TYPES)),
        );
        $this->expectExceptionMessage('Type cannot be more than 8 characters');
        $this->expectExceptionMessage('Rate cannot be more than 10 digits');
        $this->sut->create($date, $type, $rate, $subjectToVat, $client, $invoice, $agency);
    }
}
