<?php

namespace App\Http\Controllers\Owner;

use App\Models\Plan;
use App\Models\Shop;
use App\Models\ShopPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {

        $shop = Shop::with('shopPlan.plan')->where('owner_id', auth()->id())->first();

        // If shop doesn't exist, return view with default values
        if (!$shop) {
            return view('owner.dashboard', [
                'repairs' => 0,
                'activeRepairs' => 0,
                'pendingRepairs' => 0,
                'shop' => null,
                'plan' => null,
                'shopPlan' => null,
                'monthlyEarnings' => 0,
                'earningsPercentage' => 0,
                'completedThisMonth' => 0,
                'readyForPickup' => 0,
                'employeeCount' => 0,
                'recentRepairs' => collect(),
                'daysRemaining' => 0,
            ]);
        }
        $repairs = $shop->repairs()->count();
        $activeRepairs = $shop->repairs()->whereIn('status', ['pending', 'working'])->count();
        $pendingRepairs = $shop->repairs()->where('status', 'pending')->count();

        $plan = current_plan();
        $shopPlan = $shop->shopPlan ? Plan::find($shop->shopPlan->plan_id) : null;

        // Calculate current month earnings
        $currentMonthEarnings = $shop->repairs()
            ->whereIn('status', ['finished', 'pickedup'])
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('price_amount');

        // Calculate previous month earnings
        $previousMonthEarnings = $shop->repairs()
            ->whereIn('status', ['finished', 'pickedup'])
            ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
            ->whereYear('updated_at', Carbon::now()->subMonth()->year)
            ->sum('price_amount');

        // Calculate percentage change
        $earningsPercentage = 0;
        if ($previousMonthEarnings > 0) {
            $earningsPercentage = (($currentMonthEarnings - $previousMonthEarnings) / $previousMonthEarnings) * 100;
        } elseif ($currentMonthEarnings > 0) {
            $earningsPercentage = 100;
        }

        // Additional data for standard/pro plans
        $completedThisMonth = $shop->repairs()
            ->whereIn('status', ['finished', 'pickedup'])
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        $readyForPickup = $shop->repairs()
            ->where('status', 'finished')
            ->count();

        $employeeCount = $shop->employees()->count();

        $recentRepairs = $shop->repairs()
            ->with('assignedEmployee')
            ->latest()
            ->take(5)
            ->get();

        // Calculate days remaining on subscription
        $daysRemaining = 0;
        if ($shop->shopPlan && $shop->shopPlan->ends_at) {
            $daysRemaining = (int) ceil(Carbon::now()->floatDiffInDays($shop->shopPlan->ends_at, false));
            $daysRemaining = max(0, $daysRemaining);
        }

        return view('owner.dashboard', [
            'repairs' => $repairs,
            'activeRepairs' => $activeRepairs,
            'shop' => $shop,
            'plan' => $plan,
            'shopPlan' => $shopPlan,
            'monthlyEarnings' => $currentMonthEarnings,
            'earningsPercentage' => round($earningsPercentage, 1),
            'pendingRepairs' => $pendingRepairs,
            'completedThisMonth' => $completedThisMonth,
            'readyForPickup' => $readyForPickup,
            'employeeCount' => $employeeCount,
            'recentRepairs' => $recentRepairs,
            'daysRemaining' => $daysRemaining,
        ]);

    }
}
