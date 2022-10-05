<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Provider;

use App\Core\Service\Import\Client\ProviderClient;
use App\Core\Service\Import\ValueObject\RepositoryInformation;

abstract class ProviderResolver
{
    abstract public function getProvider(): ProviderClient;

    /**
     * @param string $ownerName
     * @return RepositoryInformation[]
     */
    public function importRepositories(string $ownerName): array
    {
        $provider = $this->getProvider();
        $provider->connect();
        
        return $provider->getRepositories($ownerName);
    }
}