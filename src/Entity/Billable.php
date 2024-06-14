<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Const\Billable as BillableConstants;
use App\Entity\Traits\SetId;
use App\Repository\BillableRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BillableRepository::class)]
class Billable
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\DateTime(message: 'Date must be a valid DateTime')]
    #[Assert\NotNull(message: 'Date cannot be null')]
    #[ORM\Column(name: 'date', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $date;

    #[Assert\Choice(
        choices: BillableConstants::TYPES,
        message: 'Type invalid. Must be one of: {{ choices }}',
    )]
    #[Assert\Length(max: 8, maxMessage: 'Type cannot be more than 8 characters')]
    #[Assert\NotBlank(message: 'Type cannot be empty')]
    #[Assert\NotNull(message: 'Type cannot be null')]
    #[Assert\Type('string', message: 'Type must be a string')]
    #[ORM\Column(length: 8)]
    private string $type;

    #[Assert\Length(max: 10, maxMessage: 'Rate cannot be more than 10 digits')]
    #[Assert\NotBlank(message: 'Rate cannot be empty')]
    #[Assert\NotNull(message: 'Rate cannot be null')]
    #[Assert\Type('integer', message: 'Rate must be an integer')]
    #[ORM\Column(length: 10)]
    private int $rate;

    #[Assert\NotNull(message: 'Subject to VAT cannot be null')]
    #[Assert\Type(type: 'boolean', message: 'Subject to VAT must be boolean')]
    #[ORM\Column]
    private bool $subjectToVat;

    #[Assert\Type(type: Company::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\ManyToOne(inversedBy: 'billables')]
    private ?Company $client = null;

    #[Assert\Type(type: Invoice::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\ManyToOne(inversedBy: 'billables')]
    private ?Invoice $invoice = null;

    #[Assert\Type(type: Company::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\ManyToOne]
    private ?Company $agency = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): static
    {
        $this->date = $date;

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

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function isSubjectToVat(): bool
    {
        return $this->subjectToVat;
    }

    public function setSubjectToVat(bool $subjectToVat): static
    {
        $this->subjectToVat = $subjectToVat;

        return $this;
    }

    public function getClient(): ?Company
    {
        return $this->client;
    }

    public function setClient(?Company $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getAgency(): ?Company
    {
        return $this->agency;
    }

    public function setAgency(?Company $agency): static
    {
        $this->agency = $agency;

        return $this;
    }
}
