<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactoryInterface;
use App\Repository\UserRepositoryInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture
{
    public function __construct(
        private readonly UserFactoryInterface $factory,
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createStandardUserFixture();
        $this->createAdminUserFixture();
    }

    private function createStandardUserFixture(): void
    {
        $standardUser = $this->factory->create(
            name: 'Standard User',
            username: 'standard-user',
            email: 'standard-user@lanentech.co.uk',
            password: 'password',
        );

        $this->repository->save($standardUser);
    }

    private function createAdminUserFixture(): void
    {
        $adminUser = $this->factory->create(
            name: 'Admin User',
            username: 'admin-user',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
            roles: ['ROLE_ADMIN'],
        );

        $this->repository->save($adminUser);
    }
}
