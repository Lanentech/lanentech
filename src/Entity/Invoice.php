<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\InvoiceRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Length(max: 255, maxMessage: 'Ident cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Ident cannot be empty')]
    #[Assert\NotNull(message: 'Ident cannot be null')]
    #[Assert\Type('string', message: 'Ident must be a string')]
    #[ORM\Column(length: 255)]
    private string $ident;

    #[Assert\Length(max: 255, maxMessage: 'Number cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Number cannot be empty')]
    #[Assert\NotNull(message: 'Number cannot be null')]
    #[Assert\Type('string', message: 'Number must be a string')]
    #[ORM\Column(length: 255)]
    private string $number;

    #[Assert\DateTime(message: 'Date must be a valid DateTime')]
    #[Assert\NotNull(message: 'Date cannot be null')]
    #[ORM\Column(type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $date;

    #[Assert\DateTime(message: 'Payment Due Date must be a valid DateTime')]
    #[Assert\NotNull(message: 'Payment Due Date cannot be null')]
    #[ORM\Column(name: 'payment_due_date', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $paymentDueDate;

    #[Assert\Length(max: 255, maxMessage: 'Agency Invoice Number cannot be more than 255 characters')]
    #[Assert\Type('string', message: 'Agency Invoice Number must be a string')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $agencyInvoiceNumber = null;

    public function getId(): int
    {
        return $this->id;
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
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

    public function getPaymentDueDate(): DateTimeImmutable
    {
        return $this->paymentDueDate;
    }

    public function setPaymentDueDate(DateTimeImmutable $paymentDueDate): static
    {
        $this->paymentDueDate = $paymentDueDate;

        return $this;
    }

    public function getAgencyInvoiceNumber(): ?string
    {
        return $this->agencyInvoiceNumber;
    }

    public function setAgencyInvoiceNumber(?string $agencyInvoiceNumber): static
    {
        $this->agencyInvoiceNumber = $agencyInvoiceNumber;

        return $this;
    }
}
