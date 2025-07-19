<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Car;

class CarService
{
    /**
     * Check if a car is available for rent in the given period.
     * Dates can be the same (one-day rental allowed).
     *
     * @param Car $car
     * @param string $dateFrom (Y-m-d format)
     * @param string $dateTo (Y-m-d format)
     * @return bool
     */
    public static function isAvailable(Car $car, string $dateFrom, string $dateTo): bool
    {
        $overlap = Order::where('car_id', $car->id)
            ->where(function ($query) use ($dateFrom, $dateTo) {
                $query->where(function ($q) use ($dateFrom, $dateTo) {
                    $q->where('date_from', '<=', $dateTo)
                        ->where('date_to', '>=', $dateFrom);
                });
            })
            ->whereNotIn('status', ['cancelled'])
            ->exists();
        return !$overlap;
    }

    /**
     * Get all busy dates for a car (dates with paid, non-cancelled orders).
     * Returns array of dates in 'Y-m-d' format.
     *
     * @param Car $car
     * @return array
     */
    public static function getBusyDates(Car $car): array
    {
        $orders = Order::where('car_id', $car->id)
            ->whereNotIn('status', ['cancelled'])
            ->get(['date_from', 'date_to']);

        $busyDates = [];
        foreach ($orders as $order) {
            $period = new \DatePeriod(
                new \DateTime($order->date_from),
                new \DateInterval('P1D'),
                (new \DateTime($order->date_to))->modify('+1 day')
            );
            foreach ($period as $date) {
                $busyDates[] = $date->format('Y-m-d');
            }
        }
        return array_values(array_unique($busyDates));
    }
}
