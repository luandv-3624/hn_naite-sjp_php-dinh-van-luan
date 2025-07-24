<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
       'service_package_id',
       'user_id',
       'register_date',
       'expire_date',
       'payment_method',
       'amount',
       'status'
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'expire_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }
}
