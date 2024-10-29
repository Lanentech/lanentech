<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lanentech;
use Doctrine\ORM\EntityManagerInterface;

readonly class LanentechRepository implements LanentechRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?Lanentech
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('lanentech')
            ->from(Lanentech::class, 'lanentech')
            ->where('lanentech.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof Lanentech) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('lanentech')
            ->from(Lanentech::class, 'lanentech');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof Lanentech);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('lanentech')
            ->from(Lanentech::class, 'lanentech')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof Lanentech);
        }

        return [];
    }

    public function delete(Lanentech $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?Lanentech $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }
}
