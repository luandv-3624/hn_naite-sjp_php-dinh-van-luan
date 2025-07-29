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
        $baseCurrency = Currency::where('is_default', true)->first();

        if (!$baseCurrency) {
            Log::warning(__('currency.default_currency_not_found'));
            return false;
        }

        $apiKey = config('services.currencyapi.key');
        $apiAgencyUrl = config('services.currencyapi.url');

        $response = Http::timeout(10)->get($apiAgencyUrl, [
            'apikey' => $apiKey,
            'base_currency' => $baseCurrency->code,
        ]);

        if (!$response->successful() || !isset($response['data'])) {
            Log::warning(__('currency.exchange_api_failed'), [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        }

        $rates = $response['data'];
        $today = Carbon::today()->toDateString();
        $currencies = Currency::all();

        foreach ($currencies as $currency) {
            $rate = $currency->is_default ? 1 : ($rates[$currency->code]['value'] ?? null);

            if (!$rate) {
                Log::info(__('currency.no_exchange_rate_for', ['currency' => $currency->code]));
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
    }
}
