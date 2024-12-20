<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Const\Billable as BillableConstants;
use App\Entity\Invoice;
use App\Factory\BillableFactoryInterface;
use App\Repository\BillableRepositoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BillableFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly BillableFactoryInterface $factory,
        private readonly BillableRepositoryInterface $repository,
    ) {
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
            InvoiceFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullDayBillableFixture();
        $this->createHalfDayBillableFixture();
    }

    private function createFullDayBillableFixture(): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 5, day: 12)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        /** @var Company $client */
        $client = $this->getReference(CompanyFixtures::FULLY_POPULATED_CLIENT, Company::class);
        /** @var Invoice $invoice */
        $invoice = $this->getReference(InvoiceFixtures::FULLY_POPULATED_INVOICE, Invoice::class);
        /** @var Company $agency */
        $agency = $this->getReference(CompanyFixtures::FULLY_POPULATED_AGENCY, Company::class);

        $billable = $this->factory->create(
            date: $date,
            type: BillableConstants::TYPE_FULL_DAY,
            rate: 25000,
            subjectToVat: false,
            client: $client,
            invoice: $invoice,
            agency: $agency,
        );

        $this->repository->save($billable);
    }

    private function createHalfDayBillableFixture(): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 2, day: 23)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        /** @var Company $client */
        $client = $this->getReference(CompanyFixtures::CLIENT_WITH_NO_ADDRESS, Company::class);
        /** @var Invoice $invoice */
        $invoice = $this->getReference(InvoiceFixtures::MINIMALLY_POPULATED_INVOICE, Invoice::class);
        /** @var Company $agency */
        $agency = $this->getReference(CompanyFixtures::AGENCY_WITH_NO_ADDRESS, Company::class);

        $billable = $this->factory->create(
            date: $date,
            type: BillableConstants::TYPE_HALF_DAY,
            rate: 25000,
            subjectToVat: false,
            client: $client,
            invoice: $invoice,
            agency: $agency,
        );

        $this->repository->save($billable);
    }
}
