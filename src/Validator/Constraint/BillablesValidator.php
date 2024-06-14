<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Billable;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class BillablesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Billables) {
            throw new UnexpectedTypeException($constraint, Billables::class);
        }

        if (!$value instanceof Collection) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        foreach ($value as $potentialBillable) {
            if (!$potentialBillable instanceof Billable) {
                $this->context->buildViolation($constraint->message)->addViolation();
                return;
            }
        }
    }
}
