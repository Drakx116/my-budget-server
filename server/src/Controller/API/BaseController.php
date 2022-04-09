<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    public static function generateInvalidRequestResponse(string $error = null): JsonResponse
    {
        return new JsonResponse([ 'error' => $error ?: 'Invalid request.' ], Response::HTTP_BAD_REQUEST);
    }
}
