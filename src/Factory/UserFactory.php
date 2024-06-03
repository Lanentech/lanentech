<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Carbon\CarbonImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserFactory extends BaseFactory implements UserFactoryInterface
{
    public function __construct(
        ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct($validator);
    }

    public function create(string $name, string $username, string $email, string $password, array $roles = []): User
    {
        $now = new CarbonImmutable();

        $user = new User();
        $user->setName($name);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        if (!empty($roles)) {
            $user->setRoles($roles);
        }

        $this->validateObject($user);

        return $user;
    }
}
