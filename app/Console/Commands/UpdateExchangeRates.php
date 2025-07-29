<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExchangeRateService;

class UpdateExchangeRates extends Command
{
    protected $signature = 'exchange-rates:update';

    protected $description = 'Cập nhật tỷ giá từ API mỗi ngày';

    public function handle(ExchangeRateService $service)
    {
        if ($service->updateRates()) {
            $this->info('Cập nhật tỷ giá thành công.');
        } else {
            $this->error('Không thể cập nhật tỷ giá.');
        }
    }
}
