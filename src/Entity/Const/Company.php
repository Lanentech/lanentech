<?php

declare(strict_types=1);

namespace App\Entity\Const;

class Company
{
    public const string TYPE_AGENCY = 'Agency';
    public const string TYPE_BUSINESS = 'Business';
    public const string TYPE_CLIENT = 'Client';

    public const array TYPES = [
        self::TYPE_AGENCY,
        self::TYPE_BUSINESS,
        self::TYPE_CLIENT,
    ];
}
