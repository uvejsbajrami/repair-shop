<?php

namespace App\Filament\Resources\PlanApplications\Pages;

use App\Mail\PlanApplicationApproveOrReject;
use App\Models\Plan;
use App\Models\Shop;
use App\Models\ShopPlan;
use App\Models\ShopSetting;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PlanApplications\PlanApplicationResource;

class EditPlanApplication extends EditRecord
{
 protected static string $resource = PlanApplicationResource::class;

 protected function afterSave(): void
 {
  $record = $this->record;

  switch ($record->status) {
   case 'approved':
    // Get the plan early so it's available for all branches
    $plan = Plan::find($record->plan_id);

    // Check if this is a renewal application
    if ($record->type === 'renewal' && $record->shop_id) {
     // Handle renewal - extend existing shop plan
     $shop = Shop::find($record->shop_id);

     if ($shop) {
      $shop->update(['is_active' => true]);

      $shopPlan = ShopPlan::where('shop_id', $shop->id)->first();

      if ($shopPlan) {
       // Get the plan for grace period calculation
       $plan = Plan::find($record->plan_id);

       $graceDays = $plan->getGracePeriodDays();
       $currencySymbols = ['EUR' => '€', 'MKD' => 'ден'];
       $shopSettings = ShopSetting::where('shop_id', $shop->id)->first();
       if (!$shopSettings) {
        // Create default settings if none exist
        ShopSetting::create([
         'shop_id' => $shop->id,
         'currency_code' => $record->currency_code ?? 'EUR',
         'currency_symbol' => $currencySymbols[$record->currency_code ?? 'EUR'] ?? '€',
         'language_code' => $record->language_code ?? 'en',
        ]);
       }
       // Determine the start date for extension
       // If plan is expired/grace, start from now; otherwise extend from ends_at
       $currentEndsAt = $shopPlan->ends_at ? \Carbon\Carbon::parse($shopPlan->ends_at) : now();
       $startFrom = $currentEndsAt->isPast() ? now() : $currentEndsAt;

       $newEndsAt = $startFrom->copy()->addDays($record->duration_months * 30);

       $shopPlan->update([
        'status' => 'active',
        'plan_id' => $record->plan_id,
        'billing_cycle' => $record->duration_months >= 12 ? 'yearly' : 'monthly',
        'duration_months' => $record->duration_months,
        'starts_at' => $currentEndsAt->isPast() ? now() : $shopPlan->starts_at,
        'ends_at' => $newEndsAt,
        'grace_ends_at' => $newEndsAt->copy()->addDays($graceDays),
       ]);
      
      }
     }
    } else {
     // Handle new application
     // 1. Find existing shop or create new one
     $shop = Shop::where('owner_id', $record->user_id)
      ->where('name', $record->shop_name)
      ->first();

     if ($shop) {
      // Shop exists - reactivate it and update pending plan
      $shop->update(['is_active' => true]);

      // Create default settings if none exist
      $currencySymbols = ['EUR' => '€', 'MKD' => 'ден'];
      if (!ShopSetting::where('shop_id', $shop->id)->exists()) {
       ShopSetting::create([
        'shop_id' => $shop->id,
        'currency_code' => $record->currency_code ?? 'EUR',
        'currency_symbol' => $currencySymbols[$record->currency_code ?? 'EUR'] ?? '€',
        'language_code' => $record->language_code ?? 'en',
       ]);
      }

      ShopPlan::where('shop_id', $shop->id)
       ->where('status', 'pending')
       ->update([
        'status' => 'active',
        'plan_id' => $record->plan_id,
        'billing_cycle' => $record->duration_months >= 12 ? 'yearly' : 'monthly',
        'duration_months' => $record->duration_months,
        'starts_at' => now(),
        'ends_at' => now()->addDays($record->duration_months * 30),
       ]);
     } else {
      // Create new shop
      $shop = Shop::create([
       'owner_id' => $record->user_id,
       'name' => $record->shop_name,
       'phone' => $record->applicant_phone,
       'is_active' => true,
      ]);

      // Create shop settings with user's preferences
      $currencySymbols = ['EUR' => '€', 'MKD' => 'ден'];
      ShopSetting::create([
       'shop_id' => $shop->id,
       'currency_code' => $record->currency_code ?? 'EUR',
       'currency_symbol' => $currencySymbols[$record->currency_code ?? 'EUR'] ?? '€',
       'language_code' => $record->language_code ?? 'en',
      ]);

      // Get the plan to check its slug for grace period
      $plan = Plan::find($record->plan_id);

      $graceDays = $plan->getGracePeriodDays();

      // Create ShopPlan only for new shop
      ShopPlan::create([
       'shop_id' => $shop->id,
       'plan_id' => $record->plan_id,
       'billing_cycle' => $record->duration_months >= 12 ? 'yearly' : 'monthly',
       'duration_months' => $record->duration_months,
       'status' => 'active',
       'starts_at' => now(),
       'ends_at' => now()->addDays($record->duration_months * 30),
       'grace_ends_at' => now()->addDays($record->duration_months * 30)->addDays($graceDays),
      ]);
     }
    }
    //send approval email to user
    $planEndAt = now()->addDays($record->duration_months * 30)->addDays($plan->getGracePeriodDays());
    \Mail::to($record->applicant_email)->send(new PlanApplicationApproveOrReject($record, Plan::find($record->plan_id), null, $planEndAt ));
    break;
   case 'rejected':
    // TODO: Send rejection email to user
    $message = $record->payment_notes ?? 'Your application has been rejected.';
    \Mail::to($record->applicant_email)->send(new PlanApplicationApproveOrReject($record, Plan::find($record->plan_id), $message));
    break;

   case 'pending':

   $shopPlan = ShopPlan::whereHas('shop', function ($query) use ($record) {
     $query->where('owner_id', $record->user_id)
           ->where('name', $record->shop_name);
    });
    if($shopPlan->exists()) {
     $shopPlan->update(['status' => 'pending']);

     Shop::where('owner_id', $record->user_id)
      ->where('name', $record->shop_name)
      ->update(['is_active' => false]);
    }
    break;
  }
 }
 protected function getHeaderActions(): array
 {
  return [
   DeleteAction::make(),
  ];
 }
}
