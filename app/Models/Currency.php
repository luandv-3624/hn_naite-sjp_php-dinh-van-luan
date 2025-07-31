<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'symbol', 'is_default', 'updated_at'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'updated_at' => 'datetime'
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'target_currency_code', 'code');
    }

    public function todayExchangeRate()
    {
        return $this->hasOne(ExchangeRate::class, 'target_currency_code', 'code')
                    ->where('date', Carbon::today()->toDateString());
    }
}
