<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Director;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class LanentechDirectorsValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof LanentechDirectors) {
            throw new UnexpectedTypeException($constraint, LanentechDirectors::class);
        }

        if (!$value instanceof Collection) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ key }}', 'directors')
                ->addViolation();
            return;
        }

        foreach ($value as $potentialDirector) {
            if (!$potentialDirector instanceof Director) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ key }}', 'directors')
                    ->addViolation();
                return;
            }
        }
    }
}
