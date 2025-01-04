<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\RepeatCost;
use App\Exception\EntityFactoryValidationException;
use App\Factory\RepeatCostFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RepeatCostFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private RepeatCostFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new RepeatCostFactory(
            $this->validator,
        );
    }

    public function testCreateBlankObject(): void
    {
        $result = $this->sut->createBlankObject();

        $this->assertInstanceOf(RepeatCost::class, $result);
    }

    public function testCreate(): void
    {
        $description = 'PhpStorm Annual License';
        $cost = 15823;
        $date = CarbonImmutable::parse('2023-02-23');

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($description, $cost, $date);

        $this->assertInstanceOf(RepeatCost::class, $result);
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($cost, $result->getCost());
        $this->assertEquals($date, $result->getDate());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $description = '';
        $cost = 15823;
        $date = CarbonImmutable::parse('2023-02-23');

        $violation = m::mock(ConstraintViolation::class);
        $violation->shouldReceive()->getMessage()->andReturn('Description cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($repeatCost), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($description, $cost, $date);
    }
}
