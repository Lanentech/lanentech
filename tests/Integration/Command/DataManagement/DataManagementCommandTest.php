<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command\DataManagement;

use App\Command\DataManagement\DataManagementCommand;
use App\DataManagement\AbstractDataManagementFile;
use App\Factory\DataManagementLogFactory;
use App\Factory\DataManagementLogFactoryInterface;
use App\Repository\DataManagementLogRepository;
use App\Repository\DataManagementLogRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Tests\Integration\Command\BaseTestCommand;
use App\Tests\Integration\Command\DataManagement\VersionFiles\Valid\Version20240101010101 as TestDataManagementFile;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class DataManagementCommandTest extends BaseTestCommand
{
    private const string VERSION_FILES_DIRECTORY = 'tests/Integration/Command/DataManagement/VersionFiles/';

    private DataManagementLogRepositoryInterface $dataManagementLogRepository;
    private DataManagementLogFactoryInterface $dataManagementLogFactory;
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $container = self::getContainer();

        $this->dataManagementLogRepository = $container->get(DataManagementLogRepository::class);
        $this->dataManagementLogFactory = $container->get(DataManagementLogFactory::class);
        $this->userRepository = $container->get(UserRepositoryInterface::class);
    }

    private function runCommand(): CommandTester
    {
        $application = new Application(self::$kernel);

        $command = $application->find('app:data-management:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        return $commandTester;
    }

    private function overrideCommandDataManagementDirectory(string $dataManagementFileDirectory): void
    {
        $container = self::getContainer();

        $dataManagementCommand = new DataManagementCommand(
            $container,
            $this->dataManagementLogRepository,
            $this->dataManagementLogFactory,
            $dataManagementFileDirectory,
            ['.gitkeep'],
        );

        $container->set(DataManagementCommand::class, $dataManagementCommand);
    }

    public function testExecuteWhenNoDataManagementFileExists(): void
    {
        $this->overrideCommandDataManagementDirectory(self::VERSION_FILES_DIRECTORY . 'MissingFile');

        $commandTester = $this->runCommand();

        $output = $commandTester->getDisplay();
        $this->assertEquals(Command::INVALID, $commandTester->getStatusCode());
        $this->assertStringContainsString('No DataManagement files found', $this->cleanOutput($output));
    }

    public function testExecuteWhenDataManagementFileIsMissingExtension(): void
    {
        $this->overrideCommandDataManagementDirectory(self::VERSION_FILES_DIRECTORY . 'MissingExtension');

        $commandTester = $this->runCommand();

        $output = $commandTester->getDisplay();
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString(
            sprintf('must extend %s', AbstractDataManagementFile::class),
            $this->cleanOutput($output),
        );
    }

    public function testExecuteWhenDataManagementFileThrowsException(): void
    {
        $this->overrideCommandDataManagementDirectory(self::VERSION_FILES_DIRECTORY . 'ExceptionThrowing');

        $commandTester = $this->runCommand();

        $output = $commandTester->getDisplay();
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('Error executing DataManagement file', $this->cleanOutput($output));
    }

    public function testExecuteWhenDataManagementFileExistsAndIsValid(): void
    {
        $usernameBefore = TestDataManagementFile::TEST_USER_USERNAME_BEFORE_UPDATE;
        $usernameAfter = TestDataManagementFile::TEST_USER_USERNAME_AFTER_UPDATE;

        if (!$user = $this->userRepository->findOneBy(['username' => $usernameBefore])) {
            $this->fail(sprintf('Expected test user fixture to exist with username "%s"', $usernameBefore));
        }

        $this->assertEquals($usernameBefore, $user->getUsername());

        $commandTester = $this->runCommand();
        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('executed successfully', $this->cleanOutput($output));

        $this->assertNull($this->userRepository->findOneBy(['username' => $usernameBefore]));
        $this->assertNotNull($this->userRepository->findOneBy(['username' => $usernameAfter]));
    }

    public function testExecuteWhenValidDataManagementFileHasAlreadyBeenRun(): void
    {
        $commandTester = $this->runCommand();
        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('executed successfully', $this->cleanOutput($output));

        $commandTester = $this->runCommand();
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('No new DataManagement files to run', $this->cleanOutput($output));
    }
}
