<?php

namespace App\Core\Entity;

use App\Core\Repository\RepositoryInformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepositoryInformationRepository::class)]
class RepositoryInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $repositoryName = null;

    #[ORM\Column(length: 255)]
    private ?string $providerName = null;

    #[ORM\Column]
    private ?float $trustPoints = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $repositoryCreatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepositoryName(): ?string
    {
        return $this->repositoryName;
    }

    public function setRepositoryName(string $repositoryName): self
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): self
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function getTrustPoints(): ?float
    {
        return $this->trustPoints;
    }

    public function setTrustPoints(float $trustPoints): self
    {
        $this->trustPoints = $trustPoints;

        return $this;
    }

    public function getRepositoryCreatedAt(): ?\DateTimeInterface
    {
        return $this->repositoryCreatedAt;
    }

    public function setRepositoryCreatedAt(\DateTimeInterface $repositoryCreatedAt): self
    {
        $this->repositoryCreatedAt = $repositoryCreatedAt;

        return $this;
    }
}
