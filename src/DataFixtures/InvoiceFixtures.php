<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\InvoiceFactoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use LogicException;

class InvoiceFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly InvoiceFactoryInterface $invoiceFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
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
            $this->throwExceptionWhenDateCannotBeCreated('date');
        }

        if (!$paymentDueDate = CarbonImmutable::create(year: 2023, month: 3, day: 20)) {
            $this->throwExceptionWhenDateCannotBeCreated('paymentDueDate');
        }

        $fullyPopulatedInvoice = $this->invoiceFactory->create(
            ident: 'invoice-02-28-2024-tcil',
            number: 'LT0061',
            date: $date,
            paymentDueDate: $paymentDueDate,
            agencyInvoiceNumber: '98866',
        );

        $manager->persist($fullyPopulatedInvoice);
    }

    private function createMinimallyPopulatedInvoiceFixture(ObjectManager $manager): void
    {
        if (!$date = CarbonImmutable::create(year: 2023, month: 3, day: 31)) {
            $this->throwExceptionWhenDateCannotBeCreated('date');
        }

        if (!$paymentDueDate = CarbonImmutable::create(year: 2023, month: 4, day: 20)) {
            $this->throwExceptionWhenDateCannotBeCreated('paymentDueDate');
        }

        $minimallyPopulatedInvoice = $this->invoiceFactory->create(
            ident: 'invoice-03-31-2024-tcil',
            number: 'LT0062',
            date: $date,
            paymentDueDate: $paymentDueDate,
        );

        $manager->persist($minimallyPopulatedInvoice);
    }

    private function throwExceptionWhenDateCannotBeCreated(string $key): never
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
