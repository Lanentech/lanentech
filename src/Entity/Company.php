<?php

namespace App\Entity;

use App\Entity\Const\Company as CompanyConstants;
use App\Entity\Traits\SetId;
use App\Repository\CompanyRepository;
use App\Validator\Constraint\Slug;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Length(max: 255, maxMessage: 'Name cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Name cannot be empty')]
    #[Assert\NotNull(message: 'Name cannot be null')]
    #[Assert\Type('string', message: 'Name must be a string')]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Assert\Length(max: 255, maxMessage: 'Ident cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Ident cannot be empty')]
    #[Assert\NotNull(message: 'Ident cannot be null')]
    #[Assert\Type('string', message: 'Ident must be a string')]
    #[Slug]
    #[ORM\Column(length: 255)]
    private string $ident;

    #[Assert\Choice(
        choices: CompanyConstants::TYPES,
        message: 'Type invalid. Must be one of: {{ choices }}',
    )]
    #[Assert\Length(max: 255, maxMessage: 'Type cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Type cannot be empty')]
    #[Assert\NotNull(message: 'Type cannot be null')]
    #[Assert\Type('string', message: 'Type must be a string')]
    #[ORM\Column(length: 255)]
    private string $type;

    #[Assert\Length(max: 8, maxMessage: 'Company Number cannot be more than 8 characters')]
    #[Assert\NotBlank(message: 'Company Number cannot be empty')]
    #[Assert\NotNull(message: 'Company Number cannot be null')]
    #[Assert\Type('integer', message: 'Company Number must be an integer')]
    #[ORM\Column(length: 8)]
    private int $companyNumber;

    #[Assert\Type(type: Address::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIdent(): string
    {
        return $this->ident;
    }

    public function setIdent(string $ident): static
    {
        $this->ident = $ident;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCompanyNumber(): int
    {
        return $this->companyNumber;
    }

    public function setCompanyNumber(int $companyNumber): static
    {
        $this->companyNumber = $companyNumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}
