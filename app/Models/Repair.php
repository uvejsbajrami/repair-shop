<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\User;
use App\Models\RepairLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'assigned_employee_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'device_type',
        'issue_description',
        'notes',
        'status',
        'tracking_code',
        'price_amount',
        'position',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }

    public function logs()
    {
        return $this->hasMany(RepairLog::class);
    }
}
