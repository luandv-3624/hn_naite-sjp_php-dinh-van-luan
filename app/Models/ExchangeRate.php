<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'date',
        'target_currency_code',
        'rate',
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'date' => 'date',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
