<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Invoice;
use Carbon\CarbonImmutable;

interface InvoiceFactoryInterface
{
    public function create(
        string $ident,
        string $number,
        CarbonImmutable $date,
        CarbonImmutable $paymentDueDate,
        ?string $agencyInvoiceNumber = '',
    ): Invoice;
}
