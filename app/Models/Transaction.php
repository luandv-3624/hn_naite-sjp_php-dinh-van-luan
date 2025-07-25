<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'category_id',
        'amount',
        'note',
        'is_recurring_transaction',
        'recurring_transaction_id',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_recurring_transaction' => 'boolean'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recurringTransaction()
    {
        return $this->belongsTo(RecurringTransaction::class);
    }
}
