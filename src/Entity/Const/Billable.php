<?php

declare(strict_types=1);

namespace App\Entity\Const;

class Billable
{
    public const string TYPE_FULL_DAY = 'Full Day';
    public const string TYPE_HALF_DAY = 'Half Day';

    public const array TYPES = [
        self::TYPE_FULL_DAY,
        self::TYPE_HALF_DAY,
    ];
}
