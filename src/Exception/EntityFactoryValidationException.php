<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\Exception\ValidationFailedException;

class EntityFactoryValidationException extends ValidationFailedException
{
}
