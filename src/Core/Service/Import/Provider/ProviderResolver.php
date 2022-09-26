<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Provider;

use App\Core\Service\Import\Client\ProviderClient;

abstract class ProviderResolver
{
    abstract public function getProvider(): ProviderClient;
    
    public function importRepositories(string $ownerName): array
    {
        $provider = $this->getProvider();
        $provider->connect();
        
        return $provider->getRepositories($ownerName);
    }
}