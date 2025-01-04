<?php

declare(strict_types=1);

namespace App\DataManagement;

use App\Repository\UserRepositoryInterface;

readonly class Version20240529135208 extends AbstractDataManagementFile
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function load(): void
    {
        $start = 0;
        $batchSize = 50;

        while (true) {
            if (empty($batch = $this->userRepository->fetchBatch($start, $batchSize))) {
                break;
            }

            foreach ($batch as $user) {
                $user->setName(ucwords(str_replace(['_', '-'], ' ', (string) $user->getUsername())));
            }

            $start += $batchSize;
        }

        $this->userRepository->save();
    }
}
