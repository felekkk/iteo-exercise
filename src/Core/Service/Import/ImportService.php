<?php

declare(strict_types=1);

namespace App\Core\Service\Import;

use App\Core\Handler\SynchronizeRepositoryInformation;
use Exception;
use Github\Exception\RuntimeException;
use App\Core\Service\Import\Provider\ProviderResolver;
use App\Core\Service\Import\ValueObject\RepositoryInformation;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportService
{
    /**
     * @var array<string, ProviderResolver>
     */
    private array $providers = [];

    public function __construct(private readonly MessageBusInterface $bus) {}

    public function setProvider(string $name, ProviderResolver $provider): void
    {
        $this->providers[$name] = $provider;
    }
    
    public function importRepositories(string $providerName, string $ownerName): string
    {
        if (!array_key_exists($providerName, $this->providers)) {
            throw new Exception('Provider not registred.');
        }

        /**
         * @var RepositoryInformation[] $repositories
         */
        $repositories = $this->providers[$providerName]->importRepositories($ownerName);

        foreach($repositories as $repository) {
            $this->bus->dispatch(new SynchronizeRepositoryInformation($repository));
        }

        return 'success';
    }
}