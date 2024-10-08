<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\Expense;
use App\Entity\ExpenseCategory;
use App\Exception\EntityFactoryValidationException;
use App\Factory\ExpenseFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExpenseFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private ExpenseFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new ExpenseFactory(
            $this->validator,
        );
    }

    public function testCreateBlankObject(): void
    {
        $result = $this->sut->createBlankObject();

        $this->assertInstanceOf(Expense::class, $result);
    }

    public function testCreate(): void
    {
        $expenseCategoryDescription = <<<HTML
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>employee and staff salaries</li>
                <li>bonuses</li>
                <li>pensions</li>
                <li>benefits</li>
                <li>agency fees</li>
                <li>subcontractors</li>
                <li>employer's National Insurance</li>
                <li>training courses related to your business</li>
            </ul>
            <p>You cannot claim for carers or domestic help, for example nannies.</p>
        HTML;

        $expenseCategory = new ExpenseCategory();
        $expenseCategory->setName('Staff costs');
        $expenseCategory->setDescription($expenseCategoryDescription);

        $description = 'Pension Contribution to Penfold for Teresa Green';
        $type = ExpenseConstants::TYPE_BUSINESS_COST;
        $date = CarbonImmutable::parse('2023-02-23');
        $cost = 15975;
        $comments = 'This is a comment';

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($description, $expenseCategory, $type, $date, $cost, $comments);

        $this->assertInstanceOf(Expense::class, $result);
        $this->assertEquals($description, $result->getDescription());
        $this->assertEquals($expenseCategory, $result->getCategory());
        $this->assertEquals($type, $result->getType());
        $this->assertEquals($date, $result->getDate());
        $this->assertEquals($cost, $result->getCost());
        $this->assertEquals($comments, $result->getComments());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $expenseCategoryDescription = <<<HTML
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>employee and staff salaries</li>
                <li>bonuses</li>
                <li>pensions</li>
                <li>benefits</li>
                <li>agency fees</li>
                <li>subcontractors</li>
                <li>employer's National Insurance</li>
                <li>training courses related to your business</li>
            </ul>
            <p>You cannot claim for carers or domestic help, for example nannies.</p>
        HTML;

        $expenseCategory = new ExpenseCategory();
        $expenseCategory->setName('Staff costs');
        $expenseCategory->setDescription($expenseCategoryDescription);

        $description = '';
        $type = ExpenseConstants::TYPE_BUSINESS_COST;
        $date = CarbonImmutable::parse('2023-02-23');
        $cost = 15975;
        $comments = 'This is a comment';

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn('Description cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($expense), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($description, $expenseCategory, $type, $date, $cost, $comments);
    }
}
