<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\Factory\UserFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
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
        $standardUser = $this->userFactory->create(
            name: 'Test User',
            username: 'test-user',
            email: 'test-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($standardUser);

        $adminUser = $this->userFactory->create(
            name: 'Test Admin User',
            username: 'test-admin-user',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
            roles: ['ROLE_ADMIN'],
        );
        $manager->persist($adminUser);

        $manager->flush();
    }
}
