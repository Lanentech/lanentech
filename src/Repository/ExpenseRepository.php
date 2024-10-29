<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Expense;
use Doctrine\ORM\EntityManagerInterface;

readonly class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?Expense
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expense')
            ->from(Expense::class, 'expense')
            ->where('expense.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof Expense) {
                return $result[0];
            }
        }

        return null;
    }

    public function findOneByDescription(string $description): ?Expense
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expense')
            ->from(Expense::class, 'expense')
            ->where('expense.description = :description')
            ->setParameter('description', $description);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof Expense) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expense')
            ->from(Expense::class, 'expense');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof Expense);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('expense')
            ->from(Expense::class, 'expense')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof Expense);
        }

        return [];
    }

    public function delete(Expense $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?Expense $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }
}
