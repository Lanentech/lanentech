<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\AddressFixtures as ApplicationAddressFixtures;

class AddressFixtures extends ApplicationAddressFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
