<?php
declare(strict_types=1);

namespace App\Api\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Api\Service\RepositoryService;
use App\Core\Repository\RepositoryInformationRepository;

class RepositoryServiceTest extends TestCase
{
    public function testGetProvider(): void
    {
        $repository = $this->createMock(RepositoryInformationRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->willReturn([]);

        $service = new RepositoryService($repository);

        $result = $service->getRepositoriesInformation();

        self::assertSame([], $result);
    }
}