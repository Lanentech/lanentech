<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactoryInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture
{
    public function __construct(
        private readonly UserFactoryInterface $userFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createStandardUserFixture($manager);
        $this->createAdminUserFixture($manager);

        $manager->flush();
    }

    private function createStandardUserFixture(ObjectManager $manager): void
    {
        $standardUser = $this->userFactory->create(
            name: 'Standard User',
            username: 'standard-user',
            email: 'standard-user@lanentech.co.uk',
            password: 'password',
        );

        $manager->persist($standardUser);
    }

    private function createAdminUserFixture(ObjectManager $manager): void
    {
        $adminUser = $this->userFactory->create(
            name: 'Admin User',
            username: 'admin-user',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
            roles: ['ROLE_ADMIN'],
        );

        $manager->persist($adminUser);
    }
}
