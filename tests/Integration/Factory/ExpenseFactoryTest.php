<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Entity\ExpenseCategory;
use App\Exception\EntityFactoryValidationException;
use App\Factory\ExpenseFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;
use Carbon\CarbonImmutable;

class ExpenseFactoryTest extends IntegrationTestCase
{
    private ExpenseFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(ExpenseFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
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
        $type = 'Invalid Type';
        $date = CarbonImmutable::parse('2023-02-23');
        $cost = 123456789123456;
        $comments = str_repeat('comments', 1000);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Description cannot be empty');
        $this->expectExceptionMessage('Type invalid. Must be one of');
        $this->expectExceptionMessage('Cost cannot be more than 10 digits');
        $this->expectExceptionMessage('Comments cannot be more than 5000 characters');
        $this->sut->create($description, $expenseCategory, $type, $date, $cost, $comments);
    }
}
