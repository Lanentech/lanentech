<?php

declare(strict_types=1);

namespace App\Tests\Integration\DataFixtures;

use App\Tests\TestCase\IntegrationTestCase;
use Exception;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SeedTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
    }

    #[TestWith([['--group' => ['application-fixture']]])]
    #[TestWith([['--env' => 'test', '--group' => ['test-fixture']]])]
    public function testSeedDoesNotThrowAnyErrors(array $input): void
    {
        $application = new Application(self::$kernel);

        $command = $application->find('doctrine:fixtures:load');

        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['yes']);

        try {
            $commandTester->execute($input);
        } catch (Exception $e) {
            $this->fail(
                sprintf('Failed as the fixture seeding threw an exception (Exception: %s)', $e->getMessage()),
            );
        }

        $this->assertTrue(true);
    }
}
