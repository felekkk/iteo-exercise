<?php
declare(strict_types=1);

namespace App\Core\Service\Import\ValueObject;

use DateTimeImmutable;

interface RepositoryInformation
{
    public function trustPoints(): float;
    public function ownerName(): string;
    public function repositoryName(): string;
    public function createdAt(): DateTimeImmutable;
}

