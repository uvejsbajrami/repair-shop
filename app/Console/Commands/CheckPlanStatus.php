<?php

namespace App\Console\Commands;

use App\Mail\PlanExpired;
use App\Mail\PlanGraceWarning;
use App\Models\ShopPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPlanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update plan statuses based on end dates and grace periods';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking plan statuses...');

        $now = Carbon::now();
        $updatedCount = 0;
        $emailsSent = 0;

        // Get all plans that are not already expired, eager load relationships
        $plans = ShopPlan::with(['shop.owner', 'plan'])
            ->whereIn('status', ['active', 'grace', 'pending'])
            ->get();

        /** @var ShopPlan $shopPlan */
        foreach ($plans as $shopPlan) {
            $oldStatus = $shopPlan->status;
            $newStatus = $oldStatus;

            // Check if plan has expired (past grace period)
            if ($shopPlan->grace_ends_at && $now->gt(Carbon::parse($shopPlan->grace_ends_at))) {
                $newStatus = 'expired';
            }
            // Check if plan is in grace period
            elseif ($shopPlan->ends_at && $now->gt(Carbon::parse($shopPlan->ends_at))) {
                if ($shopPlan->grace_ends_at && $now->lte(Carbon::parse($shopPlan->grace_ends_at))) {
                    $newStatus = 'grace';
                } else {
                    $newStatus = 'expired';
                }
            }

            // Update status if changed
            if ($oldStatus !== $newStatus) {
             if ($newStatus === 'expired') {
                $shopPlan->shop->update(['is_active' => false]);
              }
              $shopPlan->update(['status' => $newStatus]);
                $updatedCount++;
                $this->line("Shop Plan ID {$shopPlan->id}: {$oldStatus} → {$newStatus}");
            }

            // Send grace warning email (only once)
            if ($newStatus === 'grace' && !$shopPlan->grace_email_sent_at) {
                $this->sendGraceWarningEmail($shopPlan);
                $emailsSent++;
            }

            // Send expired email (only once)
            if ($newStatus === 'expired' && !$shopPlan->expired_email_sent_at) {
                $this->sendExpiredEmail($shopPlan);
                $emailsSent++;
            }
        }

        $this->info("Plan status check complete. Updated {$updatedCount} plan(s). Sent {$emailsSent} email(s).");

        return 0;
    }

    /**
     * Send grace period warning email to shop owner.
     */
    private function sendGraceWarningEmail(ShopPlan $shopPlan): void
    {
        $shop = $shopPlan->shop;

        if (!$shop || !$shop->owner) {
            $this->warn("Shop Plan ID {$shopPlan->id}: Cannot send grace email - shop or owner not found.");
            return;
        }

        try {
            Mail::to($shop->owner->email)->send(new PlanGraceWarning($shop, $shopPlan));

            $shopPlan->update(['grace_email_sent_at' => now()]);

            $this->line("  → Grace warning email sent to {$shop->owner->email}");
        } catch (\Exception $e) {
            $this->error("  → Failed to send grace email: {$e->getMessage()}");
        }
    }

    /**
     * Send expired notification email to shop owner.
     */
    private function sendExpiredEmail(ShopPlan $shopPlan): void
    {
        $shop = $shopPlan->shop;

        if (!$shop || !$shop->owner) {
            $this->warn("Shop Plan ID {$shopPlan->id}: Cannot send expired email - shop or owner not found.");
            return;
        }

        try {
            Mail::to($shop->owner->email)->send(new PlanExpired($shop, $shopPlan));

            $shopPlan->update(['expired_email_sent_at' => now()]);

            $this->line("  → Expired notification email sent to {$shop->owner->email}");
        } catch (\Exception $e) {
            $this->error("  → Failed to send expired email: {$e->getMessage()}");
        }
    }
}
