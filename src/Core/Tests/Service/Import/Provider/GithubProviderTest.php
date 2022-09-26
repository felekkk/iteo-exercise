<?php
declare(strict_types=1);

namespace App\Core\Tests\Service\Import\Provider;

use Github\Client;
use PHPUnit\Framework\TestCase;
use App\Core\Service\Import\Client\ProviderClient;
use App\Core\Service\Import\Provider\GithubProvider;

class GithubProviderTest extends TestCase
{
    public function testGetProvider()
    {
        $clientMock = $this->createMock(Client::class);
        $provider = new GithubProvider('', $clientMock);

        self::assertInstanceOf(ProviderClient::class, $provider->getProvider());
    }
}