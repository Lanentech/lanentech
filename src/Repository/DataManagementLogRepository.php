<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DataManagementLog;
use Doctrine\ORM\EntityManagerInterface;

readonly class DataManagementLogRepository implements DataManagementLogRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?DataManagementLog
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('dataManagementLog')
            ->from(DataManagementLog::class, 'dataManagementLog')
            ->where('dataManagementLog.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof DataManagementLog) {
                return $result[0];
            }
        }

        return null;
    }

    public function findOneByFilename(string $filename): ?DataManagementLog
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('dataManagementLog')
            ->from(DataManagementLog::class, 'dataManagementLog')
            ->where('dataManagementLog.filename = :filename')
            ->setParameter('filename', $filename);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof DataManagementLog) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('dataManagementLog')
            ->from(DataManagementLog::class, 'dataManagementLog');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof DataManagementLog);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('dataManagementLog')
            ->from(DataManagementLog::class, 'dataManagementLog')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof DataManagementLog);
        }

        return [];
    }

    public function delete(DataManagementLog $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?DataManagementLog $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }
}
