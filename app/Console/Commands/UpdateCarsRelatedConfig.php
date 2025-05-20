<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;

class UpdateCarsRelatedConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-cars-related-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $brands = Brand::withCount(['cars as real_cars_count'])->get();
        foreach ($brands as $brand) {
            $brand->cars_count = $brand->real_cars_count;
            $brand->save();
        }
    }
}
