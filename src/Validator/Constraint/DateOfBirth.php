<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class DateOfBirth extends Constraint
{
    public string $message = 'Value provided is not a valid Date of Birth';
    public string $mode = 'strict';
}
