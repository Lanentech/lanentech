<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Billable;
use App\Entity\Company;
use App\Entity\Invoice;
use Carbon\CarbonImmutable;

interface BillableFactoryInterface
{
    public function create(
        CarbonImmutable $date,
        string $type,
        int $rate,
        bool $subjectToVat,
        ?Company $client,
        ?Invoice $invoice,
        ?Company $agency,
    ): Billable;
}
