<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ExpenseCategory;
use App\Factory\ExpenseCategoryFactoryInterface;
use App\Util\Html\HtmlCleaner;
use Doctrine\Persistence\ObjectManager;

class ExpenseCategoryFixtures extends AbstractFixture
{
    public const string CAR_VAN_AND_TRAVEL = 'car_van_and_travel';
    public const string CLOTHING_EXPENSES = 'clothing_expenses';
    public const string LEGAL_AND_FINANCIAL_COSTS = 'legal_and_financial_costs';
    public const string MARKETING_ENTERTAINMENT_AND_SUBSCRIPTIONS = 'marketing_entertainment_and_subscriptions';
    public const string OFFICE_PROPERTY_AND_EQUIPMENT = 'office_property_and_equipment';
    public const string RESELLING_GOODS = 'reselling_goods';
    public const string STAFF_EXPENSES = 'staff_expenses';
    public const string TRAINING_COURSES = 'training_courses';

    public function __construct(
        private readonly ExpenseCategoryFactoryInterface $expenseCategoryFactory,
    ) {
    }

    /**
     * These fixtures are based on https://www.gov.uk/expenses-if-youre-self-employed.
     */
    public function load(ObjectManager $manager): void
    {
        $this->createOfficePropertyAndEquipmentExpenseCategoryFixture($manager);
        $this->createCarVanAndTravelExpensesExpenseCategoryFixture($manager);
        $this->createClothingExpensesExpenseCategoryFixture($manager);
        $this->createStaffExpensesExpenseCategoryFixture($manager);
        $this->createResellingGoodsExpenseCategoryFixture($manager);
        $this->createLegalAndFinancialCostsExpenseCategoryFixture($manager);
        $this->createMarketingEntertainmentAndSubscriptionsExpenseCategoryFixture($manager);
        $this->createTrainingCoursesExpenseCategoryFixture($manager);

        $manager->flush();
    }

    private function createOfficePropertyAndEquipmentExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <p>Claim items you'd normally use for less than 2 years as allowable expenses, for example:</p>
            <ul>
                <li>stationery</li>
                <li>rent, rates, power and insurance costs</li>
            </ul>
            <p>For equipment you keep to use in your business, for example computers or printers, claim:</p>
            <ul>
                <li>allowable expenses if you use cash basis accounting</li>
                <li>capital allowances if you use traditional accounting</li>
            </ul>
            <p>You cannot claim for any non-business use of premises, phones or other office resources.</p>
            <h2>Stationery</h2>
            <p>You can claim expenses for:</p>
            <ul>
                <li>phone, mobile, fax and internet bills</li>
                <li>postage</li>
                <li>stationery</li>
                <li>printing</li>
                <li>printer ink and cartridges</li>
                <li>computer software your business uses for less than 2 years</li>
                <li>
                    computer software if your business makes regular payments to renew the licence 
                    (even if you use it for more than 2 years)
                </li>
            </ul>
            <p>Claim other software for your business as capital allowances, unless you use cash basis.</p>
            <h2>Rents, rates, power and insurance costs</h2>
            <p>You can claim expenses for:</p>
            <ul>
                <li>rent for business premises</li>
                <li>business and water rates</li>
                <li>utility bills</li>
                <li>property insurance</li>
                <li>security</li>
                <li>using your home as an office (only the part that's used for business)</li>
            </ul>
            <h2>Business premises</h2>
            <p>You cannot claim expenses or allowances for buying building premises.</p>
            <p>Claim expenses for repairs and maintenance of business premises and equipment.</p>
            <p>For alterations to install or replace equipment, claim:</p>
            <ul>
                <li>allowable expenses if you use cash basis accounting</li>
                <li>capital allowances if you use traditional accounting</li>
            </ul>
            <p>
                You can also claim capital allowances for some integral parts of a building, 
                for example water heating systems.
            </p>
        HTML;

        $officePropertyAndEquipment = $this->expenseCategoryFactory->create(
            name: 'Office, property and equipment',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($officePropertyAndEquipment);

        if (!$this->hasReference(self::OFFICE_PROPERTY_AND_EQUIPMENT, ExpenseCategory::class)) {
            $this->addReference(self::OFFICE_PROPERTY_AND_EQUIPMENT, $officePropertyAndEquipment);
        }
    }

    private function createCarVanAndTravelExpensesExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <h1>Car, van and travel expenses</h1>
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>vehicle insurance</li>
                <li>repairs and servicing</li>
                <li>fuel</li>
                <li>parking</li>
                <li>hire charges</li>
                <li>vehicle licence fees</li>
                <li>breakdown cover</li>
                <li>train, bus, air and taxi fares</li>
                <li>hotel rooms</li>
                <li>meals on overnight business trips</li>
            </ul>
            <p>You cannot claim for:</p>
            <ul>
                <li>non-business driving or travel costs</li>
                <li>fines</li>
                <li>travel between home and work</li>
            </ul>
            <h2>Buying vehicles</h2>
            <p>
                If you use traditional accounting and buy a vehicle for your business,
                you can claim this as a capital allowance.
            </p>
            <p>
                If you use cash basis accounting and buy a car for your business, claim this as a capital allowance
                as long as you're not using simplified expenses.
            </p>
            <p>For all other types of vehicle, claim them as allowable expenses.</p>
        HTML;

        $carVanAndTravelExpenses = $this->expenseCategoryFactory->create(
            name: 'Car, van and travel expenses',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($carVanAndTravelExpenses);

        if (!$this->hasReference(self::CAR_VAN_AND_TRAVEL, ExpenseCategory::class)) {
            $this->addReference(self::CAR_VAN_AND_TRAVEL, $carVanAndTravelExpenses);
        }
    }

    private function createClothingExpensesExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <h1>Clothing expenses</h1>
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>uniforms</li>
                <li>protective clothing needed for your work</li>
                <li>costumes for actors or entertainers</li>
            </ul>
            <p>You cannot claim for everyday clothing (even if you wear it for work).</p>
        HTML;

        $clothingExpenses = $this->expenseCategoryFactory->create(
            name: 'Clothing expenses',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($clothingExpenses);

        if (!$this->hasReference(self::CLOTHING_EXPENSES, ExpenseCategory::class)) {
            $this->addReference(self::CLOTHING_EXPENSES, $clothingExpenses);
        }
    }

    private function createStaffExpensesExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
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

        $staffExpenses = $this->expenseCategoryFactory->create(
            name: 'Staff expenses',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($staffExpenses);

        if (!$this->hasReference(self::STAFF_EXPENSES, ExpenseCategory::class)) {
            $this->addReference(self::STAFF_EXPENSES, $staffExpenses);
        }
    }

    private function createResellingGoodsExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <h1>Reselling goods</h1>
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>goods for resale (stock)</li>
                <li>raw materials</li>
                <li>direct costs from producing goods</li>
            </ul>
            <p>You cannot claim for:</p>
            <ul>
                <li>any goods or materials bought for private use</li>
                <li>depreciation of equipment</li>
            </ul>
        HTML;

        $resellingGoods = $this->expenseCategoryFactory->create(
            name: 'Reselling goods',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($resellingGoods);

        if (!$this->hasReference(self::RESELLING_GOODS, ExpenseCategory::class)) {
            $this->addReference(self::RESELLING_GOODS, $resellingGoods);
        }
    }

    private function createLegalAndFinancialCostsExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <h1>Legal and financial costs</h1>
            <p>Accountancy, legal and other professional fees can count as allowable business expenses.</p>
            <p>You can claim costs for:</p>
            <ul>
                <li>hiring of accountants, solicitors, surveyors and architects for business reasons</li>
                <li>professional indemnity insurance premiums</li>
            </ul>
            <p>You cannot claim for:</p>
            <ul>
                <li>
                    legal costs of buying property and machinery - if you use traditional accounting,
                    claim for these costs as capital allowances
                </li>
                <li>fines for breaking the law</li>
            </ul>
            <h2>Bank, credit card and other financial charges</h2>
            <p>You can claim business costs for:</p>
            <ul>
                <li>bank, overdraft and credit card charges</li>
                <li>interest on bank and business loans</li>
                <li>hire purchase interest</li>
                <li>leasing payments</li>
                <li>alternative finance payments, for example Islamic finance</li>
            </ul>
            <p>
                If you're using cash basis accounting you can only claim
                up to &pound;500 in interest and bank charges.
            </p>
            <p>You cannot claim for repayments of loans, overdrafts or finance arrangements.</p>
            <h2>Insurance policies</h2>
            <p>You can claim for any insurance policy for your business, for example public liability insurance.</p>
            <h2>When your customer does not pay you</h2>
            <p>
                If you're using traditional accounting, you can claim for
                amounts of money you include in your turnover but will not ever receive ('bad debts').
                However, you can only write off these debts if you're sure they will not be recovered
                from your customer in the future.
            </p>
            <p>You cannot claim for:</p>
            <ul>
                <li>debts not included in turnover</li>
                <li>debts related to the disposal of fixed assets, for example land, buildings, machinery</li>
                <li>
                    bad debts that are not properly calculated, for example you can not
                    just estimate that your debts are equal to 5&percnt; of your turnover
                </li>
            </ul>
            <p>
                Bad debts cannot be claimed if you use cash basis accounting
                because you've not received the money from your debtors. With
                cash basis, you only record income on your return that you've
                actually received.
            </p>
        HTML;

        $legalAndFinancialCosts = $this->expenseCategoryFactory->create(
            name: 'Legal and financial costs',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($legalAndFinancialCosts);

        if (!$this->hasReference(self::LEGAL_AND_FINANCIAL_COSTS, ExpenseCategory::class)) {
            $this->addReference(self::LEGAL_AND_FINANCIAL_COSTS, $legalAndFinancialCosts);
        }
    }

    private function createMarketingEntertainmentAndSubscriptionsExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
            <h1>Marketing, entertainment and subscriptions</h1>
            <p>You can claim allowable business expenses for:</p>
            <ul>
                <li>advertising in newspapers or directories</li>
                <li>bulk mail advertising (mailshots)</li>
                <li>free samples</li>
                <li>website costs</li>
            </ul>
            <p>You cannot claim for:</p>
            <ul>
                <li>entertaining clients, suppliers and customers</li>
                <li>event hospitality</li>
            </ul>
            <h2>Subscriptions</h2>
            <p>You can claim for:</p>
            <ul>
                <li>trade or professional journals</li>
                <li>trade body or professional organisation membership if related to your business</li>
            </ul>
            <p>You cannot claim for:</p>
            <ul>
                <li>payments to political parties</li>
                <li>gym membership fees</li>
                <li>donations to charity - but you may be able to claim for sponsorship payments</li>
            </ul>
        HTML;

        $marketingEntertainmentAndSubscriptions = $this->expenseCategoryFactory->create(
            name: 'Marketing, entertainment and subscriptions',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($marketingEntertainmentAndSubscriptions);

        if (!$this->hasReference(self::MARKETING_ENTERTAINMENT_AND_SUBSCRIPTIONS, ExpenseCategory::class)) {
            $this->addReference(
                self::MARKETING_ENTERTAINMENT_AND_SUBSCRIPTIONS,
                $marketingEntertainmentAndSubscriptions,
            );
        }
    }

    private function createTrainingCoursesExpenseCategoryFixture(ObjectManager $manager): void
    {
        $description = <<<HTML
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

        $trainingCourses = $this->expenseCategoryFactory->create(
            name: 'Training courses',
            description: HtmlCleaner::minify($description),
        );

        $manager->persist($trainingCourses);

        if (!$this->hasReference(self::TRAINING_COURSES, ExpenseCategory::class)) {
            $this->addReference(self::TRAINING_COURSES, $trainingCourses);
        }
    }
}
