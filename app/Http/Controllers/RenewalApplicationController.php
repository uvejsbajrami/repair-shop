<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanApplication;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenewalApplicationController extends Controller
{
    /**
     * Show the renewal application form
     */
    public function showRenewApply()
    {
        $shop = Shop::with('shopPlan.plan')
            ->where('owner_id', Auth::id())
            ->first();

        if (!$shop || !$shop->shopPlan) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'No subscription found.');
        }

        // Only allow renewal application when plan is in grace or expired status
        if (!in_array($shop->shopPlan->status, ['grace', 'expired'])) {
            return redirect()->route('owner.dashboard')
                ->with('info', 'You can apply for renewal when it enters the grace period or has expired.');
        }

        // Check if there's already a pending renewal application
        $pendingRenewal = PlanApplication::where('user_id', Auth::id())
            ->where('shop_id', $shop->id)
            ->where('type', 'renewal')
            ->where('status', 'pending')
            ->exists();

        if ($pendingRenewal) {
            return redirect()->route('owner.dashboard')
                ->with('warning', 'You already have a pending renewal application.');
        }

        $plan = $shop->shopPlan->plan;

        $durations = [
            1 => '1 Month',
            3 => '3 Months',
            6 => '6 Months',
            12 => '12 Months (Save 15%)',
        ];

        return view('checkout.renew-apply', [
            'shop' => $shop,
            'plan' => $plan,
            'shopPlan' => $shop->shopPlan,
            'durations' => $durations,
        ]);
    }

    /**
     * Submit a renewal application
     */
    public function submitRenewalApplication(Request $request)
    {
        $request->validate([
            'duration_months' => 'required|in:1,3,6,12',
            'message' => 'nullable|string|max:1000',
        ]);

        $shop = Shop::with('shopPlan.plan')
            ->where('owner_id', Auth::id())
            ->first();

        if (!$shop || !$shop->shopPlan) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'No subscription found.');
        }

        // Verify plan is in grace or expired status
        if (!in_array($shop->shopPlan->status, ['grace', 'expired'])) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'Renewal only available during grace period or when expired.');
        }

        // Check for existing pending renewal
        $pendingRenewal = PlanApplication::where('user_id', Auth::id())
            ->where('shop_id', $shop->id)
            ->where('type', 'renewal')
            ->where('status', 'pending')
            ->exists();

        if ($pendingRenewal) {
            return redirect()->route('owner.dashboard')
                ->with('warning', 'You already have a pending renewal application.');
        }

        $user = Auth::user();
        $plan = $shop->shopPlan->plan;
        $durationMonths = (int) $request->duration_months;

        // Create the renewal application
        $application = PlanApplication::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'shop_id' => $shop->id,
            'shop_name' => $shop->name,
            'applicant_name' => $user->name,
            'applicant_email' => $user->email,
            'applicant_phone' => $shop->phone ?? null,
            'billing_cycle' => $durationMonths >= 12 ? 'yearly' : 'monthly',
            'duration_months' => $durationMonths,
            'message' => $request->message,
            'status' => 'pending',
            'type' => 'renewal',
            'payment_status' => 'awaiting_proof',
        ]);

        return redirect()->route('renew.apply.success')
            ->with('application_id', $application->id);
    }

    /**
     * Show success page after renewal application
     */
    public function showSuccess()
    {
        $application = null;
        if (session('application_id')) {
            $application = PlanApplication::with('plan')->find(session('application_id'));
        }

        return view('checkout.renew-apply-success', [
            'application' => $application,
        ]);
    }
}
