<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\Factory\UserFactoryInterface;
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
        private readonly UserFactoryInterface $userFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['test-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createTestStandardUserFixture($manager);
        $this->createTestAdminUserFixture($manager);

        $manager->flush();
    }

    private function createTestStandardUserFixture(ObjectManager $manager): void
    {
        $standardUser = $this->userFactory->create(
            name: 'Test User',
            username: self::NON_ADMIN_USER_USERNAME,
            email: self::NON_ADMIN_USER_EMAIL,
            password: 'password',
        );

        $manager->persist($standardUser);
    }

    private function createTestAdminUserFixture(ObjectManager $manager): void
    {
        $adminUser = $this->userFactory->create(
            name: 'Test Admin User',
            username: self::ADMIN_USER_USERNAME,
            email: self::ADMIN_USER_EMAIL,
            password: 'password',
            roles: ['ROLE_ADMIN'],
        );

        $manager->persist($adminUser);
    }
}
