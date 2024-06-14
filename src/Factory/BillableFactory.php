<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Billable;
use App\Entity\Company;
use App\Entity\Invoice;
use Carbon\CarbonImmutable;

readonly class BillableFactory extends BaseFactory implements BillableFactoryInterface
{
    public function create(
        CarbonImmutable $date,
        string $type,
        int $rate,
        bool $subjectToVat,
        ?Company $client,
        ?Invoice $invoice,
        ?Company $agency,
    ): Billable {
        $billable = new Billable();
        $billable->setDate($date);
        $billable->setType($type);
        $billable->setRate($rate);
        $billable->setSubjectToVat($subjectToVat);
        $billable->setClient($client);
        $billable->setInvoice($invoice);
        $billable->setAgency($agency);

        $this->validateObject($billable);

        return $billable;
    }
}
