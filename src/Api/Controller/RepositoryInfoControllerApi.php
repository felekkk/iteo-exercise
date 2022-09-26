<?php
declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Service\RepositoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class RepositoryInfoControllerApi extends AbstractController
{
    #[Route('/repositories', name: 'api_fetch_repositories', methods: ['GET'])]
    public function fetchRepositories(
        Request $request,
        RepositoryService $repositoryService
    ): Response {
        $sort = $request->query->get('sort') ?? 'ASC';

        $repositories = $repositoryService->getRepositoriesInformation($sort);

        return new JsonResponse(
            json_encode($repositories),
            Response::HTTP_OK,
            [],
            true
        );
    }
}