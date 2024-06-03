<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\DataManagementLogFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DataManagementLogFactoryTest extends KernelTestCase
{
    private DataManagementLogFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(DataManagementLogFactoryInterface::class);
    }

    public function testOnCreateProducesValidationFailure(): void
    {
        $invalidFilename = '';

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Filename cannot be empty');
        $this->sut->create($invalidFilename);
    }
}
