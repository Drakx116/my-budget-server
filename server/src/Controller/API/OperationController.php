<?php

namespace App\Controller\API;

use App\Entity\Operation;
use App\Entity\User;
use App\Enum\OperationType;
use App\Repository\OperationRepository;
use App\Serializer\OperationSerializer;
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
    public function list(
        Request $request,
        Security $security,
        OperationRepository $operationRepository,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $security->getUser();

        $limit = (int) $request->query->get('limit');
        $operationType = $request->query->get('type');

        $type = OperationType::fromClient($operationType);

        $operations = $operationRepository->findUserLastOperations($user, $limit, $type);

        return new JsonResponse(
            OperationSerializer::serialize($operations)
        , Response::HTTP_OK);
    }

    #[Route(path: '/summary', methods: ['GET'])]
    public function summary(Security $security, OperationRepository $operationRepository): JsonResponse
    {
        /** @var User $user */
        $user = $security->getUser();

        $summary = $operationRepository->findUserSummary($user);

        return new JsonResponse($summary, Response::HTTP_OK);
    }
}

