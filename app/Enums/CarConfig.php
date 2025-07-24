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

    case AVAILABILITY_NOW = 'now';
    case AVAILABILITY_TOMORROW = 'tomorrow';
    case AVAILABILITY_THIS_WEEK = 'this_week';
    case AVAILABILITY_NEXT_WEEK = 'next_week';
    case AVAILABILITY_NEXT_MONTH = 'next_month';
    case AVAILABILITY_SOON = 'soon';
    public function toFloat(): float
    {
        return (float) $this->value;
    }
    public function toInt(): float
    {
        return (float) $this->value;
    }
}
