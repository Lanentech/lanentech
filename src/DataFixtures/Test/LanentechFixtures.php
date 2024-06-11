<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\LanentechFixtures as ApplicationLanentechFixtures;

class LanentechFixtures extends ApplicationLanentechFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }

    public function getDependencies(): array
    {
        return [
            DirectorFixtures::class,
        ];
    }
}
