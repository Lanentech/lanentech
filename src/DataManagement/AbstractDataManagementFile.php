<?php

declare(strict_types=1);

namespace App\DataManagement;

abstract readonly class AbstractDataManagementFile
{
    abstract public function load(): void;
}
