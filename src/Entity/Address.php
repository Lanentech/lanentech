<?php

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Length(max: 50, maxMessage: 'House Name cannot be more than 50 characters')]
    #[Assert\Type('string', message: 'House Name must be a string')]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $houseName = null;

    #[Assert\Length(max: 10, maxMessage: 'House Number cannot be more than 10 characters')]
    #[Assert\NotBlank(message: 'House Number cannot be empty')]
    #[Assert\NotNull(message: 'House Number cannot be null')]
    #[Assert\Type('string', message: 'House Number must be a string')]
    #[ORM\Column(length: 10)]
    private string $houseNumber;

    #[Assert\Length(max: 75, maxMessage: 'Street cannot be more than 75 characters')]
    #[Assert\NotBlank(message: 'Street cannot be empty')]
    #[Assert\NotNull(message: 'Street cannot be null')]
    #[Assert\Type('string', message: 'Street must be a string')]
    #[ORM\Column(length: 75)]
    private string $street;

    #[Assert\Length(max: 75, maxMessage: 'Town/City cannot be more than 75 characters')]
    #[Assert\NotBlank(message: 'Town/City cannot be empty')]
    #[Assert\NotNull(message: 'Town/City cannot be null')]
    #[Assert\Type('string', message: 'Town/City must be a string')]
    #[ORM\Column(length: 75)]
    private string $townCity;

    #[Assert\Length(
        min: 5,
        max: 7,
        minMessage: 'Postcode cannot be less than 5 characters',
        maxMessage: 'Postcode cannot be more than 7 characters',
    )]
    #[Assert\NotNull(message: 'Postcode cannot be null')]
    #[Assert\Regex('/^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}|GIR ?0A{2})$/', message: 'Postcode must be valid')]
    #[Assert\Type('string', message: 'Postcode must be a string')]
    #[Assert\Type('string', message: 'Postcode must be a string')]
    #[ORM\Column(length: 7)]
    private string $postcode;

    #[Assert\Country(message: 'Country but be a 3 letter ISO code', alpha3: true)]
    #[Assert\Length(max: 3, maxMessage: 'Country cannot be more than 3 characters')]
    #[Assert\NotBlank(message: 'Country cannot be empty')]
    #[Assert\NotNull(message: 'Country cannot be null')]
    #[Assert\Type('string', message: 'Country must be a string')]
    #[ORM\Column(length: 3)]
    private string $country;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHouseName(): ?string
    {
        return $this->houseName;
    }

    public function setHouseName(?string $houseName): static
    {
        $this->houseName = $houseName;

        return $this;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): static
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getTownCity(): string
    {
        return $this->townCity;
    }

    public function setTownCity(string $townCity): static
    {
        $this->townCity = $townCity;

        return $this;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }
}
