<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExpenseCategory;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpenseCategory>
 */
class ExpenseCategoryRepository extends ServiceEntityRepository implements ExpenseCategoryRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseCategory::class);
    }
}
