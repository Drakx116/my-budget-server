<?php

namespace App\Service\Manager;

use Symfony\Component\HttpFoundation\Request;

interface ManagerInterface
{
    public function createOneFromRequest(Request $request);
}
