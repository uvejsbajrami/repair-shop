<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'plan_id',
        'billing_cycle',
        'duration_months',
        'starts_at',
        'ends_at',
        'grace_ends_at',
        'status',
        'grace_email_sent_at',
        'expired_email_sent_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'grace_ends_at' => 'datetime',
        'grace_email_sent_at' => 'datetime',
        'expired_email_sent_at' => 'datetime',
    ];

    public function shop() 
    {
        return $this->belongsTo(Shop::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
