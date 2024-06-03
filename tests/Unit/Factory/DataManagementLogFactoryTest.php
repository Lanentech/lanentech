<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\DataManagementLog;
use App\Exception\EntityFactoryValidationException;
use App\Factory\DataManagementLogFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\Carbon;
use Mockery as m;
use Mockery\MockInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataManagementLogFactoryTest extends UnitTestCase
{
    private MockInterface|ValidatorInterface $validator;

    private DataManagementLogFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new DataManagementLogFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $now = Carbon::create(2024, 1, 1, 1, 1, 1);
        Carbon::setTestNow($now);

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $filename = 'Version2024010101010101.php';
        $result = $this->sut->create($filename);

        $this->assertInstanceOf(DataManagementLog::class, $result);
        $this->assertEquals($filename, $result->getFilename());
        $this->assertEquals($now, $result->getRunTime());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $now = Carbon::create(2024, 1, 1, 1, 1, 1);
        Carbon::setTestNow($now);

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn('Filename cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($dataManagementLog), $violations));

        $filename = '';
        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($filename);
    }
}
