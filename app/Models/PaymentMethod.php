<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'method_name',
        'account_number',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}