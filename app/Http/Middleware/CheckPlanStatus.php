<?php

namespace App\Http\Middleware;

use App\Models\PlanApplication;
use App\Models\Shop;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        $shop = $this->getUserShop($user);

        // Check if user has no shop or no active plan
        if (!$shop || !$shop->shopPlan) {
            // Check if user has a pending application
            if ($this->hasPendingApplication($user)) {
                return $this->handlePendingPlan($request);
            }
            // No shop/plan and no pending application - let them through to see the "choose a plan" message
            return $next($request);
        }

        // Check for pending status on existing shopPlan
        if ($shop->shopPlan->status === 'pending') {
            return $this->handlePendingPlan($request);
        }

        if ($this->isPlanExpired($shop->shopPlan)) {
            return $this->handleExpiredPlan($request);
        }

        return $next($request);
    }

    /**
     * Get the shop associated with the user (as owner or employee).
     */
    protected function getUserShop($user): ?Shop
    {
        // Check if user is a shop owner
        if ($user->shop) {
            return $user->shop->load('shopPlan');
        }

        // Check if user is an employee
        if ($user->employee && $user->employee->shop) {
            return $user->employee->shop->load('shopPlan');
        }

        return null;
    }

    /**
     * Check if the shop's plan has expired.
     */
    protected function isPlanExpired($shopPlan): bool
    {
        if ($shopPlan->status === 'expired') {
            return true;
        }

        $now = Carbon::now();

        // Check if grace period has ended
        if ($shopPlan->grace_ends_at && $now->gt(Carbon::parse($shopPlan->grace_ends_at))) {
            return true;
        }

        // Check if plan ended and no grace period
        if ($shopPlan->ends_at && !$shopPlan->grace_ends_at && $now->gt(Carbon::parse($shopPlan->ends_at))) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has a pending plan application.
     */
    protected function hasPendingApplication($user): bool
    {
        return PlanApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Handle pending plan response.
     */
    protected function handlePendingPlan(Request $request): Response
    {
        if ($request->expectsJson() || $request->is('livewire/*')) {
            abort(403, 'Your plan application is pending. Please wait for admin approval.');
        }

        return redirect()->route('owner.dashboard')
            ->with('warning', 'Your plan application is pending. Please wait for admin approval before accessing this feature.');
    }

    /**
     * Handle expired plan response.
     */
    protected function handleExpiredPlan(Request $request): Response
    {
        if ($request->expectsJson() || $request->is('livewire/*')) {
            abort(403, 'Your plan has expired. Please renew to continue using this feature.');
        }

        return redirect()->route('owner.dashboard')
            ->with('error', 'Your plan has expired. Please renew to continue.');
    }
}
