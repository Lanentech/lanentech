<?php

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\DataManagementLogRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataManagementLogRepository::class)]
class DataManagementLog
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: false)]
    private string $filename;

    #[ORM\Column(name: 'run_time', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $runTime;

    public function getId(): int
    {
        return $this->id;
    }

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
