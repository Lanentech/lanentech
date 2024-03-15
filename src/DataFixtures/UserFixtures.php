<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\UserRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $standardUser = $this->userRepository->create(
            username: 'standard',
            email: 'standard-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($standardUser);

        $adminUser = $this->userRepository->create(
            username: 'admin',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($adminUser);

        $manager->flush();
    }
}
