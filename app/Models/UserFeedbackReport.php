<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedbackReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'content',
        'status', 'admin_id', 'admin_response', 'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
