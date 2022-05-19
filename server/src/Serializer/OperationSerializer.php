<?php

namespace App\Serializer;

use App\Entity\Operation;
use JetBrains\PhpStorm\ArrayShape;

class OperationSerializer
{
    /**
     * @param Operation[] $operations
     */
    public static function serialize(array $operations): array
    {
        return array_map(static fn(Operation $operation) => self::serializeOne($operation), $operations);
    }

    #[ArrayShape([
        'amount' => "float",
        'date' => "string",
        'label' => "string",
        'method' => "string",
        'type' => "string"
    ])]
    public static function serializeOne(Operation $operation): array
    {
        return [
            'amount' => $operation->getAmount(),
            'date' => $operation->getDate()->format('d/m/Y'),
            'label' => $operation->getLabel(),
            'method' => strtolower($operation->getMethod()->value),
            'type' => strtolower($operation->getType()->value)
        ];
    }
}
