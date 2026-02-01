<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'plan_id',
        'paypal_order_id',
        'paypal_payer_id',
        'amount',
        'currency',
        'duration_months',
        'status',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the amount in euros (from cents)
     */
    public function getAmountInEurosAttribute(): float
    {
        return $this->amount / 100;
    }
}
