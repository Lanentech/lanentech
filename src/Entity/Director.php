<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\DirectorRepository;
use App\Validator\Constraint\DateOfBirth;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DirectorRepository::class)]
class Director
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Choice(
        choices: ['Mr', 'Mrs', 'Miss', 'Ms', 'Mx', 'Sir', 'Dame', 'Dr', 'Lady', 'Lord'],
        message: 'Title invalid. Must be one of: {{ choices }}',
    )]
    #[Assert\Length(max: 5, maxMessage: 'Title cannot be more than 5 characters')]
    #[Assert\Type('string', message: 'Title must be a string')]
    #[ORM\Column(length: 5, nullable: true)]
    private ?string $title = null;

    #[Assert\Length(max: 255, maxMessage: 'Firstname cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Firstname cannot be empty')]
    #[Assert\NotNull(message: 'Firstname cannot be null')]
    #[Assert\Type('string', message: 'Firstname must be a string')]
    #[ORM\Column(length: 255)]
    private string $firstName;

    #[Assert\Length(max: 255, maxMessage: 'Lastname cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Lastname cannot be empty')]
    #[Assert\NotNull(message: 'Lastname cannot be null')]
    #[Assert\Type('string', message: 'Lastname must be a string')]
    #[ORM\Column(length: 255)]
    private string $lastName;

    #[Assert\Email(message: 'Email must be a valid email address')]
    #[Assert\Length(max: 255, maxMessage: 'Email cannot be more than 255 characters')]
    #[Assert\Type('string', message: 'Email must be a string')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[Assert\Length(max: 13, maxMessage: 'Mobile cannot be more than 13 characters')]
    #[Assert\Type('string', message: 'Mobile must be a string')]
    #[ORM\Column(length: 13, nullable: true)]
    private ?string $mobile = null;

    #[Assert\Length(max: 10, maxMessage: 'Date of Birth cannot be more than 10 characters')]
    #[Assert\Regex(
        '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d\d$/',
        message: 'Date of Birth must be a valid date',
    )]
    #[Assert\Type('string', message: 'Date of Birth must be a string')]
    #[DateOfBirth]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $dateOfBirth = null;

    #[Assert\Length(max: 255, maxMessage: 'Professional Title cannot be more than 255 characters')]
    #[Assert\Type('string', message: 'Professional Title must be a string')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $professionalTitle = null;

    #[Assert\Type(type: Lanentech::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\ManyToOne(inversedBy: 'directors')]
    private ?Lanentech $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getProfessionalTitle(): ?string
    {
        return $this->professionalTitle;
    }

    public function setProfessionalTitle(?string $professionalTitle): static
    {
        $this->professionalTitle = $professionalTitle;

        return $this;
    }

    public function getCompany(): ?Lanentech
    {
        return $this->company;
    }

    public function setCompany(?Lanentech $company): static
    {
        $this->company = $company;

        return $this;
    }
}
