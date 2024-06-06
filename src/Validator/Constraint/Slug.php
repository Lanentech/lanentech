<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Slug extends Constraint
{
    public string $message = 'Value provided is not a valid Slug';
    public string $mode = 'strict';
}
