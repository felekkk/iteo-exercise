<?php
declare(strict_types=1);

namespace App\Core\Tests\Service\Import\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Core\Service\Import\ValueObject\GithubRepositoryInformation;

class GithubRepositoryInformationTest extends TestCase
{
    /**
     * @dataProvider repositoryInformationDataProvider
     */
    public function testThatCalculateTrustPointsCorrectly(
        GithubRepositoryInformation $githubRepositoryInformation,
        float $expectedTrustPoints
    ): void
    {
        self::assertEquals($expectedTrustPoints, $githubRepositoryInformation->trustPoints());
    }

    /**
     * @return array<mixed>
     */
    private function repositoryInformationDataProvider(): array
    {
        return [
            [
                GithubRepositoryInformation::create(
                    'testOwnerName',
                    'testRepositoryName',
                    'createdAt',
                    1,
                    3,
                    4
                ),
                17.2
            ]
        ];
    }
}