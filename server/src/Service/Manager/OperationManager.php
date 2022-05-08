<?php

namespace App\Service\Manager;

use App\Entity\Operation;
use App\Entity\User;
use App\Enum\OperationType;
use App\Enum\PaymentType;
use App\Repository\OperationRepository;
use DateTime;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class OperationManager extends AbstractManager
{
    #[Pure]
    public function __construct(
        Security $security,
        private OperationRepository $operationRepository
    ) {
        parent::__construct($security);
    }

    public function createOneFromRequest(Request $request): array | Operation
    {
        /** @var ?User $user */
        if (!$user = $this->getUser()) {
            return [ 'error' => 'User not found' ];
        }

        $parameters = self::getParametersFromRequest($request);

        $operationType = $parameters['type'] ?? null;
        $paymentMethod = $parameters['method'] ?? null;
        $amount = (float) ($parameters['amount'] ?? null);
        $label = $parameters['label'] ?? null;

        if (!($operationType && $paymentMethod && $amount && $label)) {
            return [ 'error' => 'Missing parameters' ];
        }

        $type = OperationType::fromClient($operationType);
        $method = PaymentType::fromClient($paymentMethod);

        if (!($type && $method)) {
            return [ 'error' => 'Invalid operation and method type.' ];
        }

        $operation = (new Operation())
            ->setAuthor($user)
            ->setAmount($amount)
            ->setDate(new DateTime())
            ->setLabel($label)
            ->setMethod($method)
            ->setType($type);

        $this->operationRepository->add($operation, true);

        return $operation;
    }
}
