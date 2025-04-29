<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-currencies';

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
        $currencies = Currency::where('slug', '!=', 'uah')->get();

        foreach ($currencies as $currency) {
            $exchangeRate = $this->getExchangeRate($currency->slug);

            if ($exchangeRate > 0) {
                $currency->exchange_rate = $exchangeRate;
                $currency->save();

                $this->info("Updated exchange rate for {$currency->slug}: {$exchangeRate}");
            } else {
                $this->error("Failed to update exchange rate for {$currency->slug}");
            }
        }

        $this->info('Currencies updated successfully!');
    }

    private function getExchangeRate(string $slug): float
    {
        $url = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            foreach ($data as $currency) {
                if ($currency['cc'] === strtoupper($slug)) {
                    return $currency['rate'];
                }
            }

            $this->error("Exchange rate for {$slug} not found.");
            return 1.0;
        } catch (\Exception $e) {
            $this->error("Error fetching exchange rate: " . $e->getMessage());
            return 1.0;
        }
    }
}
