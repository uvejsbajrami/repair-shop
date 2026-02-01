<?php

namespace App\Models;

use App\Models\User;
use App\Models\Repair;
use App\Models\Employee;
use App\Models\ShopPlan;
use App\Models\ShopSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'phone',
        'address',
        'is_active',
    ];
    public function shopPlan()
    {
        return $this->hasOne(ShopPlan::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    public function activePlan()
    {
        return $this->hasOne(ShopPlan::class)
            ->whereIn('status', ['active', 'grace']);
    }

    public function settings()
    {
        return $this->hasOne(ShopSetting::class);
    }
}
