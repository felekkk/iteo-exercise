<?php

declare(strict_types=1);

namespace App\Core\Handler;

use App\Core\Entity\RepositoryInformation;
use App\Core\Repository\RepositoryInformationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SynchronizeRepositoryInformationHandler
{
    public function __construct(private readonly RepositoryInformationRepository $repositoryInformationRepository) {}

    public function __invoke(SynchronizeRepositoryInformation $command): void
    {
        $repositoryInformation = $command->information;

        $repository = new RepositoryInformation(
            $repositoryInformation->repositoryName(),
            $repositoryInformation->ownerName(),
            $repositoryInformation->trustPoints(),
            $repositoryInformation->createdAt()
        );
        $this->repositoryInformationRepository->add($repository);
    }
}