<?php

namespace App\Filament\Widgets;

use App\Models\Shop;
use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\ShopPlan;
use App\Models\PlanApplication;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
 protected function getStats(): array
 {
  // Calculate revenue from online payments (amount is in cents)
  $onlineRevenue = Payment::where('status', 'completed')->sum('amount') / 100;

  // Calculate revenue from offline activations (shop_plans without a matching payment)
  $offlineRevenue = ShopPlan::whereIn('status', ['active', 'grace', 'expired'])
      ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
              ->from('payments')
              ->whereColumn('payments.shop_id', 'shop_plans.shop_id')
              ->whereColumn('payments.plan_id', 'shop_plans.plan_id')
              ->where('payments.status', 'completed');
      })
      ->with('plan')
      ->get()
      ->sum(function ($shopPlan) {
          // Calculate price based on plan price and duration (prices are in euros, not cents)
          return $shopPlan->plan->calculatePrice($shopPlan->duration_months);
      });

  $totalRevenue = $onlineRevenue + $offlineRevenue;

  return [
  Stat::make('Total Revenue', number_format($totalRevenue, 2) . ' €')
            ->description('From all successful payments')
            ->descriptionIcon('heroicon-o-currency-dollar')
            ->color('success')
            ->chart([5, 10, 15, 20, 25, 30, 35]),

  Stat::make('Active Users', User::where('is_active', true)->count())
            ->description('Currently active users')
            ->descriptionIcon('heroicon-o-users')
            ->color('success')
            ->chart([7, 2, 10, 3, 15, 4, 17]), // Add mini chart
        
        Stat::make('Registered Shops', Shop::count())
            ->description('Total registered shops')
            ->descriptionIcon('heroicon-o-building-storefront')
            ->color('primary')
            ->chart([5, 10, 15, 20, 25, 30, 35]),
        
        Stat::make('Active Shops', Shop::where('is_active', true)->count())
            ->description('Currently active')
            ->descriptionIcon('heroicon-o-building-storefront')
            ->color('info')
            ->chart([10, 12, 14, 16, 18, 20, 22]),
        
        Stat::make('Inactive Shops', Shop::where('is_active', false)->count())
            ->description('Needs attention')
            ->descriptionIcon('heroicon-o-x-circle')
            ->color('danger')
            ->chart([15, 14, 13, 12, 11, 10, 9]),

       Stat::make('Plan Applications', PlanApplication::where('status', 'pending')->count())
            ->description('Needs attention')
            ->descriptionIcon('heroicon-o-x-circle')
            ->color('warning')
            ->chart([15, 14, 13, 12, 11, 10, 9]),
  ];
 }
}
