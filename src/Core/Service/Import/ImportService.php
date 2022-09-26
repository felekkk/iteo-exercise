<?php
declare(strict_types=1);

namespace App\Core\Service\Import;

use DateTime;
use Exception;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Github\Exception\RuntimeException;
use App\Core\Entity\RepositoryInformation;
use App\Core\Service\Import\Provider\ProviderResolver;
use App\Core\Repository\RepositoryInformationRepository;
use App\Core\Service\Import\ValueObject\RepositoryInformationInterface;

class ImportService
{
    private array $providers = [];

    public function __construct(
        private RepositoryInformationRepository $repositoryInformationRepository
    ) {
        $this->repositoryInformationRepository = $repositoryInformationRepository;
    }

    public function setProvider(string $name, ProviderResolver $provider): void
    {
        $this->providers[$name] = $provider;
    }
    
    public function importRepositories(string $providerName, string $ownerName): string
    {
        if (!array_key_exists($providerName, $this->providers)) {
            throw new Exception('Provider not registred.');
        }

        try {
            $repositories = $this->providers[$providerName]->importRepositories($ownerName);
        } catch (RuntimeException $e) {
            throw new Exception('Repository not found');
        }        

        foreach($repositories as $repository) {
            $repositoryData = $repository->read();

            $dateTime = DateTime::createFromFormat(DateTimeInterface::ISO8601, $repositoryData[RepositoryInformationInterface::DATE_CREATED_KEY]);
            
            $object = new RepositoryInformation();
            $object->setRepositoryName($repositoryData[RepositoryInformationInterface::OWNER_NAME_KEY]);
            $object->setOwnerName($repositoryData[RepositoryInformationInterface::REPO_NAME_KEY]);
            $object->setTrustPoints($repositoryData[RepositoryInformationInterface::TRUST_POINTS_KEY]);
            $object->setRepositoryCreatedAt($dateTime);

            $this->repositoryInformationRepository->add($object);
        }

        $this->repositoryInformationRepository->flush();

        return 'success';
    }
}