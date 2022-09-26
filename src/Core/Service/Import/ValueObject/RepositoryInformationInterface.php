<?php
declare(strict_types=1);

namespace App\Core\Service\Import\ValueObject;

interface RepositoryInformationInterface
{
    public const OWNER_NAME_KEY = 'ownerName';
    public const REPO_NAME_KEY = 'repositoryName';
    public const TRUST_POINTS_KEY = 'trustPoints';
    public const DATE_CREATED_KEY = 'createdDate';

    public function read(): array;
}

