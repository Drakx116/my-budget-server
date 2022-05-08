<?php

namespace App\Service\Manager;

use App\Service\Utils\JsonHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractManager implements ManagerInterface
{
    public function __construct(
        private Security $security
    ) {}

    protected static function getParametersFromRequest(Request $request): array
    {
        return JsonHelper::decode($request->getContent());
    }

    protected function getUser(): ?UserInterface
    {
        return $this->security->getUser();
    }
}
