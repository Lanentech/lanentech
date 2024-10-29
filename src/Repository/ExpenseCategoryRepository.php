<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExpenseCategory;
use Doctrine\ORM\EntityManagerInterface;

readonly class ExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?ExpenseCategory
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expenseCategory')
            ->from(ExpenseCategory::class, 'expenseCategory')
            ->where('expenseCategory.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof ExpenseCategory) {
                return $result[0];
            }
        }

        return null;
    }

    public function findOneByName(string $name): ?ExpenseCategory
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expenseCategory')
            ->from(ExpenseCategory::class, 'expenseCategory')
            ->where('expenseCategory.name = :name')
            ->setParameter('name', $name);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof ExpenseCategory) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('expenseCategory')
            ->from(ExpenseCategory::class, 'expenseCategory');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof ExpenseCategory);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('expenseCategory')
            ->from(ExpenseCategory::class, 'expenseCategory')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof ExpenseCategory);
        }

        return [];
    }

    public function delete(ExpenseCategory $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?ExpenseCategory $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }
}
