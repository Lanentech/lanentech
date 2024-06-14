<?php

declare(strict_types=1);

namespace App\Entity\Const;

class Director
{
    public const string TITLE_DAME = 'Dame';
    public const string TITLE_DOCTOR = 'Dr';
    public const string TITLE_LADY = 'Lady';
    public const string TITLE_LORD = 'Lord';
    public const string TITLE_MISS = 'Miss';
    public const string TITLE_MS = 'Ms';
    public const string TITLE_MR = 'Mr';
    public const string TITLE_MRS = 'Mrs';
    public const string TITLE_SIR = 'Sir';

    public const array TITLES = [
        self::TITLE_DAME,
        self::TITLE_DOCTOR,
        self::TITLE_LADY,
        self::TITLE_LORD,
        self::TITLE_MISS,
        self::TITLE_MS,
        self::TITLE_MR,
        self::TITLE_MRS,
        self::TITLE_SIR,
    ];
}
