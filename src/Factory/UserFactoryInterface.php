<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Exception\EntityFactoryValidationException;

interface UserFactoryInterface
{
    /**
     * Creates a User object and hashes the password given.
     *
     * @param string[] $roles
     *
     * @throws EntityFactoryValidationException
     */
    public function create(string $name, string $username, string $email, string $password, array $roles = []): User;
}
