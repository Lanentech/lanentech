<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Expense;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Expenses extends Constraint
{
    public string $message = 'Invalid value. Must be a Collection of "' . Expense::class . '" objects';
    public string $mode = 'strict';
}
