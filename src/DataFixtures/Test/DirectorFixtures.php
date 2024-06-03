<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\DirectorFixtures as ApplicationDirectorFixtures;

class DirectorFixtures extends ApplicationDirectorFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
