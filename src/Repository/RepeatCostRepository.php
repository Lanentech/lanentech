<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RepeatCost;
use Doctrine\ORM\EntityManagerInterface;

readonly class RepeatCostRepository implements RepeatCostRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?RepeatCost
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('repeatCost')
            ->from(RepeatCost::class, 'repeatCost')
            ->where('repeatCost.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof RepeatCost) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('repeatCost')
            ->from(RepeatCost::class, 'repeatCost');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof RepeatCost);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('repeatCost')
            ->from(RepeatCost::class, 'repeatCost')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof RepeatCost);
        }

        return [];
    }

    public function delete(RepeatCost $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?RepeatCost $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }
}
