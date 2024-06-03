<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\DataManagementLog;
use Carbon\CarbonImmutable;

readonly class DataManagementLogFactory extends BaseFactory implements DataManagementLogFactoryInterface
{
    public function create(string $filename): DataManagementLog
    {
        $dataManagementLog = new DataManagementLog();
        $dataManagementLog->setFilename($filename);
        $dataManagementLog->setRunTime(CarbonImmutable::now());

        $this->validateObject($dataManagementLog);

        return $dataManagementLog;
    }
}
