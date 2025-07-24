<?php

namespace App\Services;

use App\Models\Car;
use App\Enums\CarConfig;
use Carbon\Carbon;

class CarAvailabilityService
{
    public function updateAvailabilityLabels()
    {
        $cars = Car::with(['orders' => function($q) {
            $q->where('status', '!=', 'cancelled');
        }])->get();

        foreach ($cars as $car) {
            $nextOrder = $car->orders->sortBy('date_from')->first();
            $label = $this->getAvailabilityLabel($nextOrder);
            if ($car->availability_label !== $label) {
                $car->availability_label = $label;
                $car->save();
            }
        }
    }

    private function getAvailabilityLabel($order)
    {
        if (!$order) {
            return CarConfig::AVAILABILITY_NOW->value;
        }
        $now = Carbon::now();
        $from = Carbon::parse($order->date_from);
        $diff = $now->diffInDays($from, false);

        if ($diff < 0) {
            return CarConfig::AVAILABILITY_SOON->value;
        } elseif ($diff === 1|| $diff === 0) {
            return CarConfig::AVAILABILITY_TOMORROW->value;
        } elseif ($diff <= 7) {
            return CarConfig::AVAILABILITY_THIS_WEEK->value;
        } elseif ($diff <= 14) {
            return CarConfig::AVAILABILITY_NEXT_WEEK->value;
        } elseif ($diff <= 31) {
            return CarConfig::AVAILABILITY_NEXT_MONTH->value;
        } else {
            return CarConfig::AVAILABILITY_SOON->value;
        }
    }
}

