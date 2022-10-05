<?php
declare(strict_types=1);

namespace App\Core\Tests\Service\Import;

use Exception;
use PHPUnit\Framework\TestCase;
use Github\Exception\RuntimeException;
use App\Core\Service\Import\ImportService;
use App\Core\Service\Import\Provider\GithubProvider;
use App\Core\Repository\RepositoryInformationRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportServiceTest extends TestCase
{
    public function testSuccessImportRepositories(): void
    {
        $service = $this->getService();

        $githubClient = $this->createMock(GithubProvider::class);
        $githubClient->expects($this->once())
            ->method('importRepositories')
            ->willReturn([]);

        $service->setProvider('github', $githubClient);

        $result = $service->importRepositories('github', 'test');
        
        self::assertSame($result, 'success');
    }

    public function testProviderNotRegistred(): void
    {
        $service = $this->getService();

        $this->expectException(Exception::class);

        $result = $service->importRepositories('badProvider', 'test');
        
        self::assertSame($result, 'success');
    }

    public function testRepositoryNotFound(): void
    {
        $service = $this->getService();

        $githubClient = $this->createMock(GithubProvider::class);
        $githubClient->expects($this->once())
            ->method('importRepositories')
            ->willThrowException(new RuntimeException());
        $service->setProvider('github', $githubClient);

        $this->expectException(Exception::class);

        $result = $service->importRepositories('github', 'test');

        self::assertSame($result, 'success');
    }

    private function getService(): ImportService
    {
        $bus = $this->createMock(MessageBusInterface::class);

        $service = new ImportService($bus);
        
        return $service;
    }
}