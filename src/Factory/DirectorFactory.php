<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Director;

readonly class DirectorFactory extends BaseFactory implements DirectorFactoryInterface
{
    public function create(
        string $firstName,
        string $lastName,
        ?string $title = null,
        ?string $email = null,
        ?string $mobile = null,
        ?string $dateOfBirth = null,
        ?string $professionalTitle = null,
    ): Director {
        $director = new Director();
        $director->setTitle($title);
        $director->setFirstName($firstName);
        $director->setLastName($lastName);
        $director->setEmail($email);
        $director->setMobile($mobile);
        $director->setDateOfBirth($dateOfBirth);
        $director->setProfessionalTitle($professionalTitle);

        $this->validateObject($director);

        return $director;
    }
}
