<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Currency;
use App\Services\ExchangeRateService;

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
}
