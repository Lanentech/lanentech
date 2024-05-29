<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command\DataManagement\VersionFiles\ExceptionThrowing;

use App\DataManagement\AbstractDataManagementFile;
use Exception;

readonly class Version20240101010101 extends AbstractDataManagementFile
{
    /**
     * @throws Exception
     */
    public function load(): void
    {
        throw new Exception('Throwing to test exception catching scenario');
    }
}
