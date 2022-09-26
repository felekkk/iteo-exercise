<?php
declare(strict_types=1);

namespace App\Core\Service\Import\Client;

use Github\Client;
use Github\ResultPager;
use App\Core\Service\Import\ValueObject\GithubRepositoryInformation;

class GithubClient implements ProviderClient
{
    public function __construct(
        private string $appSecret,
        private Client $client
    ) {
        $this->client = $client;
    }

    public function connect(): void 
    {
        $this->client->authenticate($this->appSecret, null, Client::AUTH_ACCESS_TOKEN);
    }

    public function getRepositories(string $ownerName): array
    {
        $organizationApi = $this->client->api('organization');
        $paginator = new ResultPager($this->client);
        $parameters = [$ownerName];

        $repositories = $paginator->fetchAll($organizationApi, 'repositories', $parameters);

        $repos = [];
        foreach($repositories as $repostiory) {
            [
                'name' => $repositoryName,
                'created_at' => $createdAt,
                'stargazers_count' => $starsCount,
                'default_branch' => $defaultBranch
            ] = $repostiory;

            $commitCount = $this->getCommitCount($ownerName, $repositoryName, $defaultBranch);
            $pullRequestCount = $this->getPullRequestCount($ownerName, $repositoryName);

            $repos[] = GithubRepositoryInformation::create(
                $ownerName,
                $repositoryName,
                $createdAt,
                $commitCount,
                $pullRequestCount,
                $starsCount
            );
        }

        return $repos;
    }

    private function getCommitCount(
        string $ownerName,
        string $repositoryName,
        string $branchName
    ): int {
        $organizationApi = $this->client->api('repo')->commits();
        $paginator = new ResultPager($this->client);
        $parameters = [$ownerName, $repositoryName, ['sha' => $branchName]];

        return count($paginator->fetchAll($organizationApi, 'all', $parameters));
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