<?php
declare(strict_types=1);

namespace App\Api\Service;

use App\Core\Entity\RepositoryInformation;
use App\Core\Repository\RepositoryInformationRepository;

class RepositoryService
{
    public function __construct(private readonly RepositoryInformationRepository $repositoryInformationRepository) {}

    /**
     * @return RepositoryInformation[]
     */
    public function getRepositoriesInformation(string $sort = 'asc'): array
    {
        return $this->repositoryInformationRepository->findBy([], ['repositoryCreatedAt' => $sort]);
    }
}