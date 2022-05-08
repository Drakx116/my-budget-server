<?php

namespace App\Enum;

enum OperationType: string
{
    case EXPENSE = 'EXPENSE';
    case INCOME = 'INCOME';

    public static function fromClient(string $operationType): ?OperationType
    {
        return match ($operationType) {
            'expense' => self::EXPENSE,
            'income' => self::INCOME,
            default => null
        };
    }
}
