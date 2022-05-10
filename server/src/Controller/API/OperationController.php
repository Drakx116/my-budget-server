<?php

namespace App\Controller\API;

use App\Entity\Operation;
use App\Entity\User;
use App\Repository\OperationRepository;
use App\Service\Manager\OperationManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route(path: '/operations')]
class OperationController extends BaseController
{
    #[Route(path: '/create', methods: ['POST'])]
    public function create(
        Request $request,
        OperationManager $operationManager
    ): JsonResponse
    {
        $response = $operationManager->createOneFromRequest($request);

        if (!$response instanceof Operation) {
            return self::generateInvalidRequestResponse($response['error']);
        }

        return new JsonResponse([ 'message' => 'Operation created.' ], Response::HTTP_CREATED);
    }

    #[Route(path: '', methods: ['GET'])]
    public function list(Request $request, Security $security, OperationRepository $operationRepository): JsonResponse
    {
        /** @var User $user */
        $user = $security->getUser();

        $limit = (int) $request->query->get('limit');

        $operations = $operationRepository->findUserLastOperations($user, $limit);

        return new JsonResponse($operations, Response::HTTP_OK);
    }
}

