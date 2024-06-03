<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Carbon\Carbon;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DateOfBirthValidator extends ConstraintValidator
{
    private const string EXPECTED_FORMAT = 'd/m/Y';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof DateOfBirth) {
            throw new UnexpectedTypeException($constraint, DateOfBirth::class);
        }

        // Ignore null and empty values, to allow other constraints (NotBlank, NotNull, etc.).
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) || !$this->validateDate($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

    private function validateDate(string $value): bool
    {
        $date = DateTime::createFromFormat(self::EXPECTED_FORMAT, $value);

        $isValidDate = $date && $date->format(self::EXPECTED_FORMAT) === $value;

        return $isValidDate && Carbon::parse($date)->lte(Carbon::now());
    }
}
