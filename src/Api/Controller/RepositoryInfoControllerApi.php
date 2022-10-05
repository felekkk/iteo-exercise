<?php
declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Service\RepositoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class RepositoryInfoControllerApi extends AbstractController
{
    #[Route('/repositories', name: 'api_fetch_repositories', methods: ['GET'])]
    public function fetchRepositories(
        Request $request,
        RepositoryService $repositoryService
    ): JsonResponse {
        $sort = (string) ($request->query->get('sort') ?? 'ASC');

        return $this->json(
            $repositoryService->getRepositoriesInformation($sort)
        );
    }
}