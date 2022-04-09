<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Service\Manager\UserManager;
use App\Service\Utils\JsonHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/auth')]
class AuthController extends BaseController
{
    #[Route(path: '/register', methods: [ 'POST' ])]
    public function register(Request $request, UserManager $userManager): JsonResponse
    {
        $response = $userManager->createOneFromRequest(JsonHelper::decode($request->getContent()));

        if (!$response instanceof User) {
            return self::generateInvalidRequestResponse($response['error']);
        }

        return new JsonResponse([ 'message' => 'User created.' ], Response::HTTP_CREATED);
    }
}
