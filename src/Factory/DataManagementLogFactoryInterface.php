<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\DataManagementLog;
use App\Exception\EntityFactoryValidationException;

interface DataManagementLogFactoryInterface
{
    /**
     * @throws EntityFactoryValidationException
     */
    public function create(string $filename): DataManagementLog;
}
