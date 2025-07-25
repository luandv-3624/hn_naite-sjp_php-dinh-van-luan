<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'target_amount', 'initial_amount', 'end_date'
    ];

    protected $casts = [
        'end_date' => 'datetime'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
