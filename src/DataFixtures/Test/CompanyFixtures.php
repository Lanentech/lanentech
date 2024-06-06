<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\CompanyFixtures as ApplicationCompanyFixtures;

class CompanyFixtures extends ApplicationCompanyFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
