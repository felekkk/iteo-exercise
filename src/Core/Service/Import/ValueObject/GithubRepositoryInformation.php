<?php
declare(strict_types=1);

namespace App\Core\Service\Import\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeImmutableToDateTimeTransformer;

final class GithubRepositoryInformation implements RepositoryInformation
{
    private function __construct(
        private readonly string $ownerName,
        private readonly string $repositoryName,
        private readonly string $createdAt,
        private readonly int $commitCount,
        private readonly int $pullRequestCount,
        private readonly int $starsCount
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

    public function trustPoints(): float
    {
        // Ilość commitów + ilość PR*1.2 + ilość gwiazdek * 2

        return ($this->commitCount + ($this->pullRequestCount * 1.2) + $this->starsCount) * 2;
    }

    public function ownerName(): string
    {
        return $this->ownerName;
    }

    public function repositoryName(): string
    {
        return $this->repositoryName;
    }

    /**
     * @return DateTimeImmutable
     * @throws RuntimeException
     */
    public function createdAt(): DateTimeImmutable
    {
        $date = DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->createdAt);
        if (!$date) {
            throw new RuntimeException(
                sprintf('Cannot conver created at date in %s/%s repo', $this->ownerName, $this->repositoryName)
            );
        }

        return $date;
    }
}