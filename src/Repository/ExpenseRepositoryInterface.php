<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Expense;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ExpenseRepositoryInterface extends CanPersistAndFlushInterface
{
}
