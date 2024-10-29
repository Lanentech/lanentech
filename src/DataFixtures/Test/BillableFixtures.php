<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\BillableFixtures as ApplicationBillableFixtures;

class BillableFixtures extends ApplicationBillableFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
            InvoiceFixtures::class,
        ];
    }
}
