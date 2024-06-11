<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\InvoiceFixtures as ApplicationInvoiceFixtures;

class InvoiceFixtures extends ApplicationInvoiceFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
