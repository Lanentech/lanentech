<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Expense;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExpensesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Expenses) {
            throw new UnexpectedTypeException($constraint, Expenses::class);
        }

        if (!$value instanceof Collection) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        foreach ($value as $potentialExpense) {
            if (!$potentialExpense instanceof Expense) {
                $this->context->buildViolation($constraint->message)->addViolation();
                return;
            }
        }
    }
}
