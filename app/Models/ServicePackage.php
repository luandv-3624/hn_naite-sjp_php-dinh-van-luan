<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price'];

    public function userServicePackages()
    {
        return $this->hasMany(UserServicePackage::class);
    }
}
