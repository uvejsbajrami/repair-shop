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
        $endsAt = $now->copy()->addDays($durationMonths * 30);
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
     *
     * Renewal is only allowed during grace period.
     * The new subscription extends from the old end date (not from today),
     * so the user doesn't lose any days.
     */
    public function renewSubscription(Shop $shop, int $durationMonths): ShopPlan
    {
        $shopPlan = $shop->shopPlan;
        $plan = $shopPlan->plan;

        $now = Carbon::now();
        $currentEndsAt = $shopPlan->ends_at ? Carbon::parse($shopPlan->ends_at) : $now;

        // Always extend from the old end date (grace period renewal)
        // This ensures the user doesn't lose any days from the grace period
        $endsAt = $currentEndsAt->copy()->addDays($durationMonths * 30);
        $graceEndsAt = $endsAt->copy()->addDays($plan->getGracePeriodDays());

        // Update the shop plan
        $shopPlan->update([
            'billing_cycle' => $durationMonths >= 12 ? 'yearly' : 'monthly',
            'duration_months' => $durationMonths,
            'starts_at' => $currentEndsAt, // New period starts from old end date
            'ends_at' => $endsAt,
            'grace_ends_at' => $graceEndsAt,
            'grace_email_sent_at' => null, // Reset grace email
            'expired_email_sent_at' => null, // Reset expired email
            'status' => 'active', // Immediately active after renewal
        ]);

        // Ensure shop is active
        $shop->update(['is_active' => true]);

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
