<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Shop;
use App\Models\ShopPlan;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * Calculate the total price for a plan and duration
     * Returns amount in euros (not cents)
     */
    public function calculatePrice(Plan $plan, int $durationMonths): float
    {
        return $plan->calculatePrice($durationMonths);
    }

    /**
     * Get the savings for 12-month subscription
     */
    public function getYearlySavings(Plan $plan): float
    {
        return $plan->getYearlySavings();
    }

    /**
     * Activate a new subscription for a shop
     */
    public function activateSubscription(Shop $shop, Plan $plan, int $durationMonths): ShopPlan
    {
        $now = Carbon::now();
        $endsAt = $now->copy()->addMonths($durationMonths);
        $graceEndsAt = $endsAt->copy()->addDays($plan->getGracePeriodDays());

        // Delete any existing shop plan
        $shop->shopPlan()->delete();

        // Create new shop plan
        $shopPlan = ShopPlan::create([
            'shop_id' => $shop->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $durationMonths >= 12 ? 'yearly' : 'monthly',
            'duration_months' => $durationMonths,
            'starts_at' => $now,
            'ends_at' => $endsAt,
            'grace_ends_at' => $graceEndsAt,
            'status' => 'active',
        ]);

        // Activate the shop
        $shop->update(['is_active' => true]);

        return $shopPlan;
    }

    /**
     * Renew an existing subscription
     */
    public function renewSubscription(Shop $shop, int $durationMonths): ShopPlan
    {
        $shopPlan = $shop->shopPlan;
        $plan = $shopPlan->plan;

        // Calculate new dates
        // If plan is still active, extend from ends_at; otherwise start from now
        $now = Carbon::now();
        $currentEndsAt = $shopPlan->ends_at ? Carbon::parse($shopPlan->ends_at) : null;

        if ($currentEndsAt && $currentEndsAt->gt($now)) {
            // Plan still active, extend from current end date
            $startsAt = $currentEndsAt;
        } else {
            // Plan expired, start from now
            $startsAt = $now;
        }

        $endsAt = $startsAt->copy()->addMonths($durationMonths);
        $graceEndsAt = $endsAt->copy()->addDays($plan->getGracePeriodDays());

        // Update the shop plan
        $shopPlan->update([
            'billing_cycle' => $durationMonths >= 12 ? 'yearly' : 'monthly',
            'duration_months' => $durationMonths,
            'starts_at' => $now,
            'ends_at' => $endsAt,
            'grace_ends_at' => $graceEndsAt,
            'status' => 'active',
        ]);

        return $shopPlan->fresh();
    }

    /**
     * Get price breakdown for display
     */
    public function getPriceBreakdown(Plan $plan, int $durationMonths): array
    {
        $totalPrice = $plan->calculatePrice($durationMonths);
        $originalPrice = $plan->price_monthly * $durationMonths;
        $savings = $originalPrice - $totalPrice;
        $discountPercent = $durationMonths === 12 ? 15 : 0;

        return [
            'monthly_price' => $plan->price_monthly,
            'duration_months' => $durationMonths,
            'original_price' => $originalPrice,
            'total_price' => $totalPrice,
            'savings' => $savings,
            'discount_percent' => $discountPercent,
            'price_per_month' => round($totalPrice / $durationMonths, 2),
        ];
    }
}
