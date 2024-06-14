<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\RepeatCostFixtures as ApplicationRepeatCostFixtures;

class RepeatCostFixtures extends ApplicationRepeatCostFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
