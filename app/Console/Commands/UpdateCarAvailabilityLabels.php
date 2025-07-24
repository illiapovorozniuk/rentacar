<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CarAvailabilityService;

class UpdateCarAvailabilityLabels extends Command
{
    protected $signature = 'cars:update-availability-labels';
    protected $description = 'Update car availability labels based on active orders';

    public function handle(CarAvailabilityService $service)
    {
        $service->updateAvailabilityLabels();
        $this->info('Car availability labels updated.');
    }
}

