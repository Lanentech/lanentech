<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\DataManagementLog;
use App\Factory\DataManagementLogFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\Carbon;

class DataManagementLogFactoryTest extends UnitTestCase
{
    private DataManagementLogFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new DataManagementLogFactory();
    }

    public function testCreate(): void
    {
        $now = Carbon::create(2024, 1, 1, 1, 1, 1);
        Carbon::setTestNow($now);

        $filename = 'Version2024010101010101.php';

        $result = $this->sut->create($filename);

        $this->assertInstanceOf(DataManagementLog::class, $result);
        $this->assertEquals($filename, $result->getFilename());
        $this->assertEquals($now, $result->getRunTime());
    }
}
