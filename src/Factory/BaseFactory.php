<?php

declare(strict_types=1);

namespace App\Factory;

use App\Exception\EntityFactoryValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class BaseFactory
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
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
