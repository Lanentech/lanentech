<?php

declare(strict_types=1);

namespace App\Entity\Const;

class Expense
{
    public const string TYPE_BUSINESS_COST = 'Business Cost';
    public const string TYPE_DIRECTORS_EXPENSE = 'Directors Expense';

    public const array TYPES = [
        self::TYPE_BUSINESS_COST,
        self::TYPE_DIRECTORS_EXPENSE,
    ];
}
