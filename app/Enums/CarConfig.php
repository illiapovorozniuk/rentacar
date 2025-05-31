<?php

namespace App\Enums;

enum CarConfig: string
{
    case PRICE7_MULTIPLIER = '0.85';
    case PRICE30_MULTIPLIER = '0.75';
    case PRICE31MORE_MULTIPLIER = '0.7';
    case KM_DAILY = '250';
    case KM_WEEKLY = '1400';
    case KM_MONTHLY = '3500';
    public function toFloat(): float
    {
        return (float) $this->value;
    }
    public function toInt(): float
    {
        return (float) $this->value;
    }
}
