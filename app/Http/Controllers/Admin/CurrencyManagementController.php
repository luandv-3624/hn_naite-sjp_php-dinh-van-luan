<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrencyManagementController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        $currenciesQuery = Currency::with(['exchangeRates' => function ($query) use ($selectedDate) {
            $query->where('date', $selectedDate);
        }]);

        if ($search) {
            $currenciesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $currencies = $currenciesQuery->orderBy('id')->paginate(self::PER_PAGE);

        return view('admin.currency-management.index', [
            'currencies' => $currencies,
            'selectedDate' => $selectedDate,
            'search' => $search,
        ]);
    }

    public function updateExchangeRates(ExchangeRateService $service)
    {
        $success = $service->updateRates();
        if ($success) {
            return redirect()->back()->with('success', __('currency.update_exchange_rates_success'));
        }

        return redirect()->back()->with('error', __('currency.update_exchange_rates_error'));
    }

    public function changeCurrencyDefault(Currency $currency, ExchangeRateService $service)
    {
        DB::beginTransaction();
        try {
            Currency::where('is_default', true)->update(['is_default' => false]);

            $currency->update(['is_default' => true]);

            $success = $this->updateRates($currency);

            if (!$success) {
                return redirect()->back()->with('error', __('currency.update_exchange_rates_error'));
            }

            DB::commit();

            return redirect()->back()->with('success', __('currency.set_default_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(__('currency.set_default_error'), ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', __('currency.set_default_error'));
        }
    }

    public function updateRates(Currency $newCurrencyDefault): bool
    {
        try {
            $dates = ExchangeRate::select('date')->distinct()->pluck('date');

            foreach ($dates as $date) {
                // Lấy toàn bộ ExchangeRate theo ngày
                $exchangeRateByDates = ExchangeRate::where('date', $date)->get();

                $newExchangeRateByDate = $exchangeRateByDates->firstWhere('target_currency_code', $newCurrencyDefault->code)->rate;

                //đồng nào muốn chuyển sang default:
                //exchange rate của đồng đó: chia cho chính nó
                //những đồng khác: lấy rate hiện tại / rate của đồng đó
                foreach ($exchangeRateByDates as $exchangeRateByDate) {
                    $exchangeRateByDate->update([
                        'currency_id' => $newCurrencyDefault->id,
                        'rate' =>  $exchangeRateByDate->rate / $newExchangeRateByDate,
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error(__('currency.set_default_error'), ['error' => $e->getMessage()]);

            return false;
        }
    }
}
