<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class DataManagementLog
{
    use GetId;
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(max: 255, maxMessage: 'Filename cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Filename cannot be empty')]
    #[Assert\Type('string', message: 'Filename must be a string')]
    #[ORM\Column(length: 255, nullable: false)]
    private string $filename;

    #[Assert\DateTime(message: 'Run Time must be a valid DateTime')]
    #[Assert\NotNull(message: 'Run Time cannot be null')]
    #[ORM\Column(name: 'run_time', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $runTime;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getRunTime(): DateTimeImmutable
    {
        return $this->runTime;
    }

    public function setRunTime(DateTimeImmutable $runTime): static
    {
        $this->runTime = $runTime;

        return $this;
    }
}
