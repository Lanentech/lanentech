<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraint;

use App\DataFixtures\ExpenseCategoryFixtures;
use App\Entity\Address;
use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\Expense;
use App\Entity\ExpenseCategory;
use App\Validator\Constraint\Expenses;
use App\Validator\Constraint\ExpensesValidator;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ExpensesValidatorTest extends ConstraintValidatorTestCase
{
    private function getDummyExpense(): Expense
    {
        $expenseCategoryDescription = <<<HTML
            <h1>Training courses</h1>
            <p>You can claim allowable business expenses for training that helps you:</p>
            <ul>
                <li>improve skills and knowledge you currently use for your business</li>
                <li>keep up-to-date with technology used in your industry</li>
                <li>develop new skills and knowledge related to changes in your industry</li>
                <li>develop new skills and knowledge to support your business - this includes administrative skills</li>
            </ul>
            <p>You cannot claim for training courses that help you:</p>
            <ul>
                <li>start a new business</li>
                <li>expand into new areas of business that are not directly related to what you currently do</li>
            </ul>
        HTML;

        $expenseCategory = (new ExpenseCategory())
            ->setName(ExpenseCategoryFixtures::TRAINING_COURSES_NAME)
            ->setDescription($expenseCategoryDescription);

        return (new Expense())
            ->setDescription('Symfony 7 online course')
            ->setCategory($expenseCategory)
            ->setType(ExpenseConstants::TYPE_DIRECTORS_EXPENSE)
            ->setDate(CarbonImmutable::now())
            ->setCost(14999);
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new ExpensesValidator();
    }

    public function testWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new ArrayCollection([$this->getDummyExpense()]), new NotBlank());
    }

    public function testWhenValueProvidedIsNotAnArrayCollection(): void
    {
        $this->validator->validate([$this->getDummyExpense()], new Expenses());

        $this->buildViolation('Invalid value. Must be a Collection of "' . Expense::class . '" objects')
            ->assertRaised();
    }

    public function testValueProvidedIsNotValidExpenseObject(): void
    {
        $this->validator->validate(new ArrayCollection([new Address()]), new Expenses());

        $this->buildViolation('Invalid value. Must be a Collection of "' . Expense::class . '" objects')
            ->assertRaised();
    }

    public function testValueProvidedIsValid(): void
    {
        $this->validator->validate(new ArrayCollection([$this->getDummyExpense()]), new Expenses());

        $this->assertNoViolation();
    }
}
