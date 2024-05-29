<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DataManagementLog;
use App\Repository\Traits\CanPersistAndFlush;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataManagementLog>
 */
class DataManagementLogRepository extends ServiceEntityRepository implements DataManagementLogRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataManagementLog::class);
    }

    public function create(string $filename): DataManagementLog
    {
        $dataManagementLog = new DataManagementLog();
        $dataManagementLog->setFilename($filename);
        $dataManagementLog->setRunTime(CarbonImmutable::now());

        return $dataManagementLog;
    }
}
