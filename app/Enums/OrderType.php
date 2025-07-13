<?php

namespace App\Enums;

enum OrderType: string
{
    case PAYMENT_PENDING = 'pending';
    case PAYMENT_PAID = 'paid';

}
