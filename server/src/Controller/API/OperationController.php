<?php

namespace App\Controller\API;

use App\Entity\Operation;
use App\Service\Manager\OperationManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
