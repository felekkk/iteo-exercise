<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Client;

interface ProviderClient
{
    public function connect(): void;

    /**
     * @param string $ownerName
     * @return array<mixed>
     */
    public function getRepositories(string $ownerName): array;
}