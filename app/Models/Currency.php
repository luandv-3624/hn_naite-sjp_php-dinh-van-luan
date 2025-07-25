<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'symbol', 'exchange_rate', 'is_default', 'updated_at'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'updated_at' => 'datetime'
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
