<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Director;

interface DirectorFactoryInterface
{
    public function create(
        string $firstName,
        string $lastName,
        ?string $title = null,
        ?string $email = null,
        ?string $mobile = null,
        ?string $dateOfBirth = null,
        ?string $professionalTitle = null,
    ): Director;
}
