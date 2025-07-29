<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExchangeRateService
{
    public function updateRates(): bool
    {
        try {
            $baseCurrency = Currency::where('is_default', true)->first();

            if (!$baseCurrency) {
                Log::warning('Default currency not found');
                return false;
            }

            $apiKey = config('services.currencyapi.key');
            $apiAgencyUrl = config('services.currencyapi.url');

            $response = Http::timeout(10)->get($apiAgencyUrl, [
                'apikey' => $apiKey,
                'base_currency' => $baseCurrency->code,
            ]);

            if (!$response->successful() || !isset($response['data'])) {
                Log::warning('Failed to fetch exchange rates from API', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

            $rates = $response['data'];
            $today = Carbon::today()->toDateString();
            $currencies = Currency::select(['id', 'code', 'is_default'])->get();

            foreach ($currencies as $currency) {
                $rate = $currency->is_default ? 1 : ($rates[$currency->code]['value'] ?? null);

                if (!$rate) {
                    Log::info("No exchange rate found for $currency->code");
                    continue;
                }

                $record = ExchangeRate::updateOrCreate([
                    'target_currency_code' => $currency->code,
                    'date' => $today,
                ], [
                    'currency_id' => $baseCurrency->id,
                    'rate' => $rate,
                ]);

                $record->touch();
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Exception during exchange rate update', [
                   'message' => $e->getMessage(),
                   'trace' => $e->getTraceAsString(),
               ]);
            return false;
        }
    }
}
