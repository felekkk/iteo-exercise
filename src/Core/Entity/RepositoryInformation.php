<?php

namespace App\Core\Entity;

use DateTimeImmutable;
use JsonSerializable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Repository\RepositoryInformationRepository;

#[ORM\Entity(repositoryClass: RepositoryInformationRepository::class)]
class RepositoryInformation implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $repositoryName;

    #[ORM\Column(length: 255)]
    private string $ownerName;

    #[ORM\Column]
    private float $trustPoints;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $repositoryCreatedAt;

    public function __construct(
        string $repositoryName,
        string $ownerName,
        float $trustPoints,
        DateTimeImmutable $createdAt
    ) {
        $this->repositoryName = $repositoryName;
        $this->ownerName = $ownerName;
        $this->trustPoints = $trustPoints;
        $this->repositoryCreatedAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function changeTrustPoints(float $trustPoints): self
    {
        $this->trustPoints = $trustPoints;

        return $this;
    }

    /**
     * @return array{id: int|null, repositoryName: string, ownerName: string, trustPoints: float, dateCreated: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'repositoryName' => $this->repositoryName,
            'ownerName' => $this->ownerName,
            'trustPoints' => $this->trustPoints,
            'dateCreated' => $this->repositoryCreatedAt->format('Y-m-d'),
        ];
    }
}
