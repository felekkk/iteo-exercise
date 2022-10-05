<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Client;

use App\Core\Service\Import\ValueObject\RepositoryInformation;
use Github\Api\Repo;
use Github\Client;
use Github\ResultPager;
use App\Core\Service\Import\ValueObject\GithubRepositoryInformation;

class GithubClient implements ProviderClient
{
    public function __construct(
        private string $appSecret,
        private Client $client
    ) {}

    public function connect(): void 
    {
        $this->client->authenticate($this->appSecret, null, Client::AUTH_ACCESS_TOKEN);
    }

    /**
     * @param string $ownerName
     * @return RepositoryInformation[]
     */
    public function getRepositories(string $ownerName): array
    {
        $organizationApi = $this->client->api('organization');
        $paginator = new ResultPager($this->client);

        return array_map(
            function (array $repository) use ($ownerName) {
                [
                    'name' => $repositoryName,
                    'created_at' => $createdAt,
                    'stargazers_count' => $starsCount,
                    'default_branch' => $defaultBranch
                ] = $repository;

                $commitCount = $this->getCommitCount($ownerName, $repositoryName, $defaultBranch);
                $pullRequestCount = $this->getPullRequestCount($ownerName, $repositoryName);

                return GithubRepositoryInformation::create(
                    $ownerName,
                    $repositoryName,
                    $createdAt,
                    $commitCount,
                    $pullRequestCount,
                    $starsCount
                );
            },
            $paginator->fetch($organizationApi, 'repositories', [$ownerName])
        );
    }

    private function getCommitCount(
        string $ownerName,
        string $repositoryName,
        string $branchName
    ): int {
        /**
         * @var Repo $api
         */
        $api = $this->client->api('repo');
        $commitsApi = $api->commits();
        $paginator = new ResultPager($this->client);
        $parameters = [$ownerName, $repositoryName, ['sha' => $branchName]];

        return count($paginator->fetchAll($commitsApi, 'all', $parameters));
    }

    private function getPullRequestCount(
        string $ownerName,
        string $repositoryName
    ): int {
        $organizationApi = $this->client->api('pull_request');
        $paginator = new ResultPager($this->client);
        $parameters = [$ownerName, $repositoryName, ['state' => 'all']];

        return count($paginator->fetchAll($organizationApi, 'all', $parameters));
    }
} 