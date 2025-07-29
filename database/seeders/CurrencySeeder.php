<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\ExchangeRate;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tiền tệ mặc định để quy đổi của hệ thống(USD)
        Currency::create([
            'name' => 'Đô la Mỹ',
            'code' => 'USD',
            'symbol' => '$',
            'is_default' => true,
            'updated_at' => now(),
        ]);

        Currency::insert([
            [
                'name' => 'Việt Nam Đồng',
                'code' => 'VND',
                'symbol' => '₫',
                'is_default' => false,
                'updated_at' => now(),
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'is_default' => false,
                'updated_at' => now(),
            ],
            [
                'name' => 'Yên Nhật',
                'code' => 'JPY',
                'symbol' => '¥',
                'is_default' => false,
                'updated_at' => now(),
            ],
        ]);

        $currencies = Currency::all();

        $baseCurrency = Currency::where('is_default', true)->firstOrFail();

        foreach (range(0, 10) as $i) {
            $date = now()->subDays($i)->toDateString();

            foreach ($currencies as $currency) {
                ExchangeRate::create([
                    'currency_id' => $baseCurrency->id,
                    'date' => $date,
                    'target_currency_code' => $currency->code,
                    'rate' => match ($currency->code) {
                        'VND' => 25000 + rand(-100, 100),
                        'EUR' => 0.90 + mt_rand(-10, 10) / 1000,
                        'JPY' => 140 + rand(-2, 2),
                        default => 1,
                    },
                ]);
            }
        }
    }
}
