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

       $graceDays = match ($plan->slug) {
        'basic' => 3,
        'standard' => 5,
        'pro' => 7,
        default => 3,
       };
       $shopSettings = ShopSetting::where('shop_id', $shop->id)->first();
       if (!$shopSettings) {
        // Create default settings if none exist
        ShopSetting::create([
         'shop_id' => $shop->id,
        ]);
       }
       // Determine the start date for extension
       // If plan is expired/grace, start from now; otherwise extend from ends_at
       $currentEndsAt = $shopPlan->ends_at ? \Carbon\Carbon::parse($shopPlan->ends_at) : now();
       $startFrom = $currentEndsAt->isPast() ? now() : $currentEndsAt;

       $newEndsAt = $startFrom->copy()->addMonths($record->duration_months);

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
      if (!ShopSetting::where('shop_id', $shop->id)->exists()) {
       ShopSetting::create(['shop_id' => $shop->id]);
      }

      ShopPlan::where('shop_id', $shop->id)
       ->where('status', 'pending')
       ->update([
        'status' => 'active',
        'plan_id' => $record->plan_id,
        'billing_cycle' => $record->duration_months >= 12 ? 'yearly' : 'monthly',
        'duration_months' => $record->duration_months,
        'starts_at' => now(),
        'ends_at' => now()->addMonths($record->duration_months),
       ]);
     } else {
      // Create new shop
      $shop = Shop::create([
       'owner_id' => $record->user_id,
       'name' => $record->shop_name,
       'phone' => $record->applicant_phone,
       'is_active' => true,
      ]);

      // Create default shop settings
      ShopSetting::create(['shop_id' => $shop->id]);

      // Get the plan to check its slug for grace period
      $plan = Plan::find($record->plan_id);

      $graceDays = match ($plan->slug) {
       'basic' => 3,
       'standard' => 5,
       'pro' => 7,
       default => 3,
      };

      // Create ShopPlan only for new shop
      ShopPlan::create([
       'shop_id' => $shop->id,
       'plan_id' => $record->plan_id,
       'billing_cycle' => $record->duration_months >= 12 ? 'yearly' : 'monthly',
       'duration_months' => $record->duration_months,
       'status' => 'active',
       'starts_at' => now(),
       'ends_at' => now()->addMonths($record->duration_months),
       'grace_ends_at' => now()->addMonths($record->duration_months)->addDays($graceDays),
      ]);
     }
    }
    //send approval email to user
    $planEndAt = now()->addMonths($record->duration_months)->addDays($plan->slug === 'basic' ? 3 : ($plan->slug === 'standard' ? 5 : 7));
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
