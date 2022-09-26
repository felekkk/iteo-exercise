<?php
declare(strict_types=1);

namespace App\Core\Tests\Service\Import\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Core\Service\Import\ValueObject\GithubRepositoryInformation;
use App\Core\Service\Import\ValueObject\RepositoryInformationInterface;

class GithubRepositoryInformationTest extends TestCase
{
    /**
    * @dataProvider repositoryInformationDataProvider
    */
    public function testGithubRepositoryInformation(array $data, array $expected)
    {
        $result = array_shift($data)->read();

        self::assertSame($result, $expected);
    }

    private function repositoryInformationDataProvider(): array
    {
        return [
            [
                [
                    GithubRepositoryInformation::create(
                        'testOwnerName',
                        'testRepositoryName',
                        'createdAt',
                        1,
                        3,
                        4
                    )
                ],
                [
                    'ownerName' => "testOwnerName",
                    'repositoryName' => "testRepositoryName",
                    'trustPoints' => 17.2,
                    'createdDate' => "createdAt",
                ]
            ]
        ];
    }
}