<?php

declare(strict_types=1);

namespace App\Factory;

use App\Exception\EntityFactoryValidationException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class BaseFactory
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @param array<int, Constraint> $constraints
     *
     * @throws EntityFactoryValidationException
     */
    protected function performPreValidationChecks(mixed $value, array $constraints): void
    {
        $errors = $this->validator->validate($value, $constraints);

        if ($errors->count() > 0) {
            throw new EntityFactoryValidationException($value, $errors);
        }
    }

    /**
     * @throws EntityFactoryValidationException
     */
    protected function validateObject(object $object): void
    {
        $errors = $this->validator->validate($object);

        if ($errors->count() > 0) {
            throw new EntityFactoryValidationException($object, $errors);
        }
    }
}
