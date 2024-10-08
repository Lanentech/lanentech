<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Expense;
use App\Repository\Traits\CanDelete;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expense>
 */
class ExpenseRepository extends ServiceEntityRepository implements ExpenseRepositoryInterface
{
    use CanDelete;
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expense::class);
    }
}
