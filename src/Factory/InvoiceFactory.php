<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Invoice;
use Carbon\CarbonImmutable;

readonly class InvoiceFactory extends BaseFactory implements InvoiceFactoryInterface
{
    public function create(
        string $ident,
        string $number,
        CarbonImmutable $date,
        CarbonImmutable $paymentDueDate,
        ?string $agencyInvoiceNumber = '',
    ): Invoice {
        $invoice = new Invoice();
        $invoice->setIdent($ident);
        $invoice->setNumber($number);
        $invoice->setDate($date);
        $invoice->setPaymentDueDate($paymentDueDate);
        $invoice->setAgencyInvoiceNumber($agencyInvoiceNumber);

        $this->validateObject($invoice);

        return $invoice;
    }
}
