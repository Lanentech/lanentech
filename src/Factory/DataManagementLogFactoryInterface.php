<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\DataManagementLog;

interface DataManagementLogFactoryInterface
{
    public function create(string $filename): DataManagementLog;
}
