<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Billable;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Billables extends Constraint
{
    public string $message = 'Invalid value. Must be a Collection of "' . Billable::class . '" objects';
    public string $mode = 'strict';
}
