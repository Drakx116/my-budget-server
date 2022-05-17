<?php

namespace App\Controller\API;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route(path: '/account')]
class AccountController extends BaseController
{
    #[Route(path: '')]
    public function __invoke(Security $security): JsonResponse
    {
        /** @var User $user */
        $user = $security->getUser();

        return new JsonResponse([
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'email' => $user->getEmail(),
            'birthdate' => $user->getBirthDate()?->format('d/m/Y')
        ], Response::HTTP_OK);
    }
}
