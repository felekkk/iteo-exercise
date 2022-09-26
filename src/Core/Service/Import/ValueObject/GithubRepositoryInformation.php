<?php
declare(strict_types=1);

namespace App\Core\Service\Import\ValueObject;

use App\Core\Service\Import\ValueObject\RepositoryInformationInterface;

final class GithubRepositoryInformation implements RepositoryInformationInterface
{
    private function __construct(
        private string $ownerName,
        private string $repositoryName,
        private string $createdAt,
        private int $commitCount,
        private int $pullRequestCount,
        private int $starsCount
    ) {}

    public static function create(
        string $ownerName,
        string $repositoryName,
        string $createdAt,
        int $commitCount,
        int $pullRequestCount,
        int $starsCount
    ): self {
        return new self(
            $ownerName,
            $repositoryName,
            $createdAt,
            $commitCount,
            $pullRequestCount,
            $starsCount
        );
    }

    private function countTrustPoints(): float
    {
        // Ilość commitów + ilość PR*1.2 + ilość gwiazdek * 2

        return ($this->commitCount + ($this->pullRequestCount * 1.2) + $this->starsCount) * 2;
    }

    public function read(): array
    {
        return [
            RepositoryInformationInterface::OWNER_NAME_KEY => $this->ownerName,
            RepositoryInformationInterface::REPO_NAME_KEY => $this->repositoryName,
            RepositoryInformationInterface::TRUST_POINTS_KEY => $this->countTrustPoints(),
            RepositoryInformationInterface::DATE_CREATED_KEY => $this->createdAt
        ];
    }
}