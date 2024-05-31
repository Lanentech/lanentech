<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Carbon\CarbonImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function create(string $name, string $username, string $email, string $password, array $roles = []): User
    {
        $user = new User();

        $user->setName($name);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $now = new CarbonImmutable();
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        if (!empty($roles)) {
            $user->setRoles($roles);
        }

        return $user;
    }
}
