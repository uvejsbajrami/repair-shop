<?php

namespace App\Models;

use App\Models\ShopPlan;
use App\Models\PlanApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price_monthly',
        'price_yearly',
        'max_employees',
        'max_active_repairs',
        'drag_and_drop',
        'branding',
        'exports',
    ];

    /**
     * Get the route key for model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function applications()
    {
        return $this->hasMany(PlanApplication::class);
    }

    public function shopPlans()
    {
        return $this->hasMany(ShopPlan::class);
    }

    /**
     * Get the grace period days based on plan type
     */
    public function getGracePeriodDays(): int
    {
        return match($this->slug) {
            'free', 'basic' => 3,
            'standard' => 5,
            'pro' => 7,
            default => 3,
        };
    }

    /**
     * Calculate the price for a given duration
     * 12 months gets 15% discount
     */
    public function calculatePrice(int $durationMonths): int
    {
        $basePrice = $this->price_monthly * $durationMonths;

        if ($durationMonths === 12) {
            // 15% discount for yearly
            return (int) round($basePrice * 0.85);
        }

        return $basePrice;
    }

    /**
     * Get savings amount for 12 months
     */
    public function getYearlySavings(): int
    {
        $fullPrice = $this->price_monthly * 12;
        $discountedPrice = $this->calculatePrice(12);

        return $fullPrice - $discountedPrice;
    }
}
