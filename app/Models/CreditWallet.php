<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'credit_limit', 'statement_date', 'payment_due_date'
    ];

    protected $casts = [
        'statement_date' => 'datetime',
        'payment_due_date' => 'datetime'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
