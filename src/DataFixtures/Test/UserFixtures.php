<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\Factory\UserFactoryInterface;
use App\Repository\UserRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const string ADMIN_USER_EMAIL = 'admin-user@lanentech.co.uk';
    public const string ADMIN_USER_USERNAME = 'test-admin-user';
    public const string NON_ADMIN_USER_EMAIL = 'test-user@lanentech.co.uk';
    public const string NON_ADMIN_USER_USERNAME = 'test-user';

    public function __construct(
        private readonly UserFactoryInterface $factory,
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public static function getGroups(): array
    {
        return ['test-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createTestStandardUserFixture();
        $this->createTestAdminUserFixture();

        $manager->flush();
    }

    private function createTestStandardUserFixture(): void
    {
        $standardUser = $this->factory->create(
            name: 'Test User',
            username: self::NON_ADMIN_USER_USERNAME,
            email: self::NON_ADMIN_USER_EMAIL,
            password: 'password',
        );

        $this->repository->save($standardUser);
    }

    private function createTestAdminUserFixture(): void
    {
        $adminUser = $this->factory->create(
            name: 'Test Admin User',
            username: self::ADMIN_USER_USERNAME,
            email: self::ADMIN_USER_EMAIL,
            password: 'password',
            roles: ['ROLE_ADMIN'],
        );

        $this->repository->save($adminUser);
    }
}
