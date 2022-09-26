<?php
declare(strict_types=1);

namespace App\Api\Service;

use App\Core\Repository\RepositoryInformationRepository;

class RepositoryService
{
    public function __construct(
        private RepositoryInformationRepository $repositoryInformationRepository
    ) {
        $this->repositoryInformationRepository = $repositoryInformationRepository;
    }

    public function getRepositoriesInformation(string $sort): array
    {
        return $this->repositoryInformationRepository->findBy([], ['repositoryCreatedAt' => $sort]);
    }
}