<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command\DataManagement\VersionFiles\Valid;

use App\DataManagement\AbstractDataManagementFile;
use App\Repository\UserRepositoryInterface;

readonly class Version20240101010101 extends AbstractDataManagementFile
{
    public const string TEST_USER_USERNAME_BEFORE_UPDATE = 'test-user';
    public const string TEST_USER_USERNAME_AFTER_UPDATE = 'test-user-name-updated';

    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function load(): void
    {
        if ($user = $this->userRepository->findOneBy(['username' => self::TEST_USER_USERNAME_BEFORE_UPDATE])) {
            $user->setUsername(self::TEST_USER_USERNAME_AFTER_UPDATE);
        }

        $this->userRepository->flush();
    }
}
