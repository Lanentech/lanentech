<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Factory\InvoiceFactoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends AbstractFixture
{
    public const string FULLY_POPULATED_INVOICE = 'fully_populated_invoice';
    public const string MINIMALLY_POPULATED_INVOICE = 'minimally_populated_invoice';

    public function __construct(
        private readonly InvoiceFactoryInterface $invoiceFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedInvoiceFixture($manager);
        $this->createMinimallyPopulatedInvoiceFixture($manager);

        $manager->flush();
    }

    private function createFullyPopulatedInvoiceFixture(ObjectManager $manager): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 2, day: 28)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        if (!$paymentDueDate = CarbonImmutable::create(year: 2023, month: 3, day: 20)) {
            $this->throwExceptionWhenDateCannotBeCreated('Payment Due Date');
        }

        $fullyPopulatedInvoice = $this->invoiceFactory->create(
            ident: 'invoice-02-28-2024-tcil',
            number: 'LT0061',
            date: $date,
            paymentDueDate: $paymentDueDate,
            agencyInvoiceNumber: '98866',
        );

        $manager->persist($fullyPopulatedInvoice);

        if (!$this->hasReference(self::FULLY_POPULATED_INVOICE, Invoice::class)) {
            $this->addReference(self::FULLY_POPULATED_INVOICE, $fullyPopulatedInvoice);
        }
    }

    private function createMinimallyPopulatedInvoiceFixture(ObjectManager $manager): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 3, day: 31)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        if (!$paymentDueDate = CarbonImmutable::create(year: 2023, month: 4, day: 20)) {
            $this->throwExceptionWhenDateCannotBeCreated('Payment Due Date');
        }

        $minimallyPopulatedInvoice = $this->invoiceFactory->create(
            ident: 'invoice-03-31-2024-tcil',
            number: 'LT0062',
            date: $date,
            paymentDueDate: $paymentDueDate,
        );

        $manager->persist($minimallyPopulatedInvoice);

        if (!$this->hasReference(self::MINIMALLY_POPULATED_INVOICE, Invoice::class)) {
            $this->addReference(self::MINIMALLY_POPULATED_INVOICE, $minimallyPopulatedInvoice);
        }
    }
}
