<?php

namespace App\Enums;

enum OrderType: string
{
    case PAYMENT_PENDING = 'pending';
    case PAYMENT_PAID = 'paid';
    case PAYMENT_CANCELLED = 'cancelled';
    case STATUS_CONFIRMED = 'confirmed';
    case STATUS_COMPLETED = 'completed';
}
