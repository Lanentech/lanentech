<?php

declare(strict_types=1);

namespace App\Tests\TestCase;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;
}
