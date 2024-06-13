<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\ExpenseCategory;
use App\Exception\EntityFactoryValidationException;
use App\Factory\ExpenseCategoryFactory;
use App\Tests\TestCase\UnitTestCase;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExpenseCategoryFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private ExpenseCategoryFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new ExpenseCategoryFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $name = 'Staff Costs';
        $description = '<p>You can claim allowable business expenses for:' .
            '<ul>' .
            '<li>employee and staff salaries</li>' .
            '<li>bonuses</li>' .
            '<li>pensions</li>' .
            '<li>benefits</li>' .
            '<li>agency fees</li>' .
            '<li>subcontractors</li>' .
            '<li>employer\'s national insurance</li>' .
            '<li>training courses related to your business</li>' .
            '</ul>' .
            '<p>You cannot claim for carers or domestic help, for example nannies.</p>';

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($name, $description);

        $this->assertInstanceOf(ExpenseCategory::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($description, $result->getDescription());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $name = '';
        $description = <<<HTML
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>employee and staff salaries</li>
                <li>bonuses</li>
                <li>pensions</li>
                <li>benefits</li>
                <li>agency fees</li>
                <li>subcontractors</li>
                <li>employer’s National Insurance</li>
                <li>training courses related to your business</li>
            </ul>
            <p>You cannot claim for carers or domestic help, for example nannies.</p>
        HTML;

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn('Name cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($expenseCategory), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($name, $description);
    }
}
