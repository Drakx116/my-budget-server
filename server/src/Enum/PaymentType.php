<?php

namespace App\Enum;

enum PaymentType: string
{
    case CASH = 'CASH';
    case CHECK = 'CHECK';
    case CREDIT_CARD = 'CREDIT_CARD';
    case MEAL_VOUCHER = 'MEAL_VOUCHER';

    public static function fromClient(string $paymentType): ?PaymentType
    {
        return match ($paymentType) {
            'cash' => self::CASH,
            'check' => self::CHECK,
            'credit_card' => self::CREDIT_CARD,
            'meal_voucher' => self::MEAL_VOUCHER,
            default => null
        };
    }
}
