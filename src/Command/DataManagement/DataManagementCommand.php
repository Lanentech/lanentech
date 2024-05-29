<?php

declare(strict_types=1);

namespace App\Command\DataManagement;

use App\DataManagement\AbstractDataManagementFile;
use App\Repository\DataManagementLogRepositoryInterface;
use App\Util\ClassHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Throwable;

#[AsCommand(
    name: 'app:data-management:run',
    description: 'Command that will execute DataManagement files, to update data in the database',
)]
class DataManagementCommand extends Command
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly DataManagementLogRepositoryInterface $repository,
        private readonly string $dataManagementFileDirectory,
        /** @var string[] */
        private readonly array $dataManagementFileNamesToIgnore = [],
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (empty($dataManagementFiles = $this->getDataManagementFiles())) {
            $io->warning('No DataManagement files found. No actions performed');
            return Command::INVALID;
        }

        $dataManagementFileRan = false;

        foreach ($dataManagementFiles as $filename) {
            if ($this->shouldSkipLoadingDataManagementFile($filename)) {
                continue;
            }

            $className = $this->getClassNameFromFilename($filename);

            if (!is_subclass_of($className, AbstractDataManagementFile::class)) {
                $io->error(sprintf('"%s" must extend %s', $className, AbstractDataManagementFile::class));
                return Command::FAILURE;
            }

            try {
                $this->runDataManagementFile($className);

                $io->success(sprintf('DataManagement file "%s" has been executed successfully', $filename));

                if (!$dataManagementFileRan) {
                    $dataManagementFileRan = true;
                }

                $this->createNewDataManagementLog($filename);
            } catch (Throwable $e) {
                $io->error(sprintf('Error executing DataManagement file "%s": "%s"', $filename, $e->getMessage()));
                return Command::FAILURE;
            }
        }

        if (!$dataManagementFileRan) {
            $io->warning('No new DataManagement files to run');
        }

        return Command::SUCCESS;
    }

    /**
     * @return string[]
     */
    private function getDataManagementFiles(): array
    {
        if (!$files = scandir($this->dataManagementFileDirectory)) {
            return [];
        }

        $filteredFiles = array_diff($files, array_merge(['.', '..'], $this->dataManagementFileNamesToIgnore));

        return array_values($filteredFiles);
    }

    private function shouldSkipLoadingDataManagementFile(string $filename): bool
    {
        return !str_contains($filename, 'Version') || $this->repository->findOneBy(['filename' => $filename]);
    }

    private function getClassNameFromFilename(string $filename): string
    {
        $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);

        return sprintf(
            '%s\\%s',
            ClassHelper::getNamespace($this->dataManagementFileDirectory . '/' . $filename),
            $filenameWithoutExtension,
        );
    }

    private function runDataManagementFile(string $className): void
    {
        /** @var AbstractDataManagementFile $dataManagementFile */
        $dataManagementFile = $this->container->get($className);
        $dataManagementFile->load();
    }

    private function createNewDataManagementLog(string $filename): void
    {
        $dataManagementLog = $this->repository->create($filename);

        $this->repository->persist($dataManagementLog);
        $this->repository->flush();
    }
}
