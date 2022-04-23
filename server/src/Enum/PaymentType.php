<?php

namespace App\Enum;

enum PaymentType: string
{
    case CASH = 'CASH';
    case CHECK = 'CHECK';
    case CREDIT_CARD = 'CREDIT_CARD';
    case MEAL_VOUCHER = 'MEAL_VOUCHER';
}
