<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RenewController extends Controller
{
    protected PayPalService $paypalService;
    protected SubscriptionService $subscriptionService;

    public function __construct(PayPalService $paypalService, SubscriptionService $subscriptionService)
    {
        $this->paypalService = $paypalService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display the renewal page
     */
    public function showRenew()
    {
        $shop = Shop::with('shopPlan.plan')
            ->where('owner_id', Auth::id())
            ->first();

        if (!$shop || !$shop->shopPlan) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'No active subscription found.');
        }

        $plan = $shop->shopPlan->plan;

        $durations = [
            1 => '1 Month',
            3 => '3 Months',
            6 => '6 Months',
            12 => '12 Months (Save 15%)',
        ];

        $priceBreakdown = $this->subscriptionService->getPriceBreakdown($plan, 1);

        return view('checkout.renew', [
            'shop' => $shop,
            'plan' => $plan,
            'shopPlan' => $shop->shopPlan,
            'durations' => $durations,
            'priceBreakdown' => $priceBreakdown,
            'paypalClientId' => config('paypal.sandbox.client_id'),
        ]);
    }

    /**
     * Calculate price for AJAX request
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'duration_months' => 'required|in:1,3,6,12',
        ]);

        $shop = Shop::with('shopPlan.plan')
            ->where('owner_id', Auth::id())
            ->first();

        if (!$shop || !$shop->shopPlan) {
            return response()->json(['error' => 'No subscription found'], 404);
        }

        $plan = $shop->shopPlan->plan;
        $durationMonths = (int) $request->duration_months;

        $breakdown = $this->subscriptionService->getPriceBreakdown($plan, $durationMonths);

        return response()->json($breakdown);
    }

    /**
     * Create PayPal order for renewal
     */
    public function createRenewOrder(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'duration_months' => 'required|in:1,3,6,12',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $shop = Shop::with('shopPlan.plan')
                ->where('owner_id', Auth::id())
                ->first();

            if (!$shop || !$shop->shopPlan) {
                return response()->json(['error' => 'No subscription found'], 404);
            }

            $plan = $shop->shopPlan->plan;
            $durationMonths = (int) $request->duration_months;
            $totalPrice = $plan->calculatePrice($durationMonths);

            // Store renewal data in session
            session([
                'renew_data' => [
                    'shop_id' => $shop->id,
                    'plan_id' => $plan->id,
                    'duration_months' => $durationMonths,
                    'total_price' => $totalPrice,
                ],
            ]);

            $description = "Renewal: {$plan->name} Plan - {$durationMonths} month(s)";

            $order = $this->paypalService->createOrder($totalPrice, $description);

            if (isset($order['id'])) {
                return response()->json([
                    'id' => $order['id'],
                ]);
            }

            return response()->json(['error' => 'Failed to create PayPal order'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Capture PayPal order after approval
     */
    public function captureRenewOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $renewData = session('renew_data');

        if (!$renewData) {
            return response()->json(['error' => 'Session expired'], 400);
        }

        try {
            $result = $this->paypalService->captureOrder($request->order_id);

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                DB::beginTransaction();

                try {
                    $shop = Shop::with('shopPlan.plan')->findOrFail($renewData['shop_id']);

                    // Renew subscription
                    $this->subscriptionService->renewSubscription(
                        $shop,
                        $renewData['duration_months']
                    );

                    // Get payer info
                    $payerId = $result['payer']['payer_id'] ?? null;
                    $paymentSource = array_key_first($result['payment_source'] ?? []);

                    // Create payment record
                    Payment::create([
                        'user_id' => Auth::id(),
                        'shop_id' => $shop->id,
                        'plan_id' => $renewData['plan_id'],
                        'paypal_order_id' => $request->order_id,
                        'paypal_payer_id' => $payerId,
                        'amount' => $renewData['total_price'] * 100, // Convert to cents
                        'currency' => 'EUR',
                        'duration_months' => $renewData['duration_months'],
                        'status' => 'completed',
                        'payment_method' => $paymentSource === 'card' ? 'card' : 'paypal',
                    ]);

                    DB::commit();

                    // Clear session data
                    session()->forget('renew_data');

                    return response()->json([
                        'success' => true,
                        'redirect' => route('owner.dashboard'),
                        'message' => 'Renewal successful! Your subscription has been extended.',
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }

            return response()->json(['error' => 'Payment not completed'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
