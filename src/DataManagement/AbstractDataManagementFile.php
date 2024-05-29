<?php

declare(strict_types=1);

namespace App\DataManagement;

readonly abstract class AbstractDataManagementFile
{
    abstract public function load(): void;
}
