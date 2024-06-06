<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SlugValidator extends ConstraintValidator
{
    private const string SLUG_REGEX_PATTERN = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Slug) {
            throw new UnexpectedTypeException($constraint, Slug::class);
        }

        // Ignore null and empty values, to allow other constraints (NotBlank, NotNull, etc.).
        if (null === $value || '' === $value) {
            return;
        }

        if (is_string($value) && !preg_match(self::SLUG_REGEX_PATTERN, $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
