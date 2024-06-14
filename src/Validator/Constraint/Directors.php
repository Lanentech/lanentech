<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Director;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class Directors extends Constraint
{
    public string $message = 'Invalid "{{ key }}" value. Must be a Collection of "' . Director::class . '" objects';
    public string $mode = 'strict';
}
