<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Provider;

use Github\Client;
use App\Core\Service\Import\Client\GithubClient;
use App\Core\Service\Import\Client\ProviderClient;
use App\Core\Service\Import\Provider\ProviderResolver;

class GithubProvider extends ProviderResolver
{
    public function __construct(
        private string $appSecret,
        private Client $client
    ) {}

    public function getProvider(): ProviderClient
    {
        return new GithubClient($this->appSecret, $this->client);
    }
}