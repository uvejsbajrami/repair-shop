<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Shop;
use App\Models\User;
use App\Models\Payment;
use App\Mail\ShopOpenMail;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\SubscriptionService;

class CheckoutController extends Controller
{
 protected PayPalService $paypalService;
 protected SubscriptionService $subscriptionService;

 public function __construct(PayPalService $paypalService, SubscriptionService $subscriptionService)
 {
  $this->paypalService = $paypalService;
  $this->subscriptionService = $subscriptionService;
 }

 /**
  * Display the checkout page
  */
 public function showCheckout(Plan $plan)
 {
  $durations = [
   1 => '1 Month',
   3 => '3 Months',
   6 => '6 Months',
   12 => '12 Months (Save 15%)',
  ];

  $priceBreakdown = $this->subscriptionService->getPriceBreakdown($plan, 1);

  return view('checkout.index', [
   'plan' => $plan,
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
   'plan_id' => 'required|exists:plans,id',
   'duration_months' => 'required|in:1,3,6,12',
  ]);

  $plan = Plan::findOrFail($request->plan_id);
  $durationMonths = (int) $request->duration_months;

  $breakdown = $this->subscriptionService->getPriceBreakdown($plan, $durationMonths);

  return response()->json($breakdown);
 }

 /**
  * Create PayPal order
  */
 public function createOrder(Request $request)
 {
  try {
   $rules = [
    'plan_id' => 'required|exists:plans,id',
    'duration_months' => 'required|in:1,3,6,12',
    'shop_name' => 'required|string|max:255',
    'shop_phone' => 'nullable|string|max:20',
    'shop_address' => 'nullable|string|max:500',
   ];

   // Add user fields validation for guests
   if (!Auth::check()) {
    $rules['name'] = 'required|string|max:255';
    $rules['email'] = 'required|email|max:255';
    $rules['password'] = 'required|string|min:8';
   }

   $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

   if ($validator->fails()) {
    return response()->json(['error' => $validator->errors()->first()], 422);
   }

   $plan = Plan::findOrFail($request->plan_id);
   $durationMonths = (int) $request->duration_months;
   $totalPrice = $plan->calculatePrice($durationMonths);

   // Store checkout data in session for later
   session([
    'checkout_data' => [
     'plan_id' => $plan->id,
     'duration_months' => $durationMonths,
     'shop_name' => $request->shop_name,
     'shop_phone' => $request->shop_phone,
     'shop_address' => $request->shop_address,
     'name' => $request->name,
     'email' => $request->email,
     'password' => $request->password,
     'total_price' => $totalPrice,
    ],
   ]);

   $description = "{$plan->name} Plan - {$durationMonths} month(s)";

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
 public function captureOrder(Request $request)
 {
  $request->validate([
   'order_id' => 'required|string',
  ]);

  $checkoutData = session('checkout_data');

  if (!$checkoutData) {
   return response()->json(['error' => 'Session expired'], 400);
  }

  try {
   $result = $this->paypalService->captureOrder($request->order_id);

   if (isset($result['status']) && $result['status'] === 'COMPLETED') {
    DB::beginTransaction();

    try {
     // Create or get user
     $user = Auth::user();
     if (!$user) {
      // Check if user already exists
      $existingUser = User::where('email', $checkoutData['email'])->first();
      if ($existingUser) {
       $user = $existingUser;
      } else {
       $user = User::create([
        'name' => $checkoutData['name'],
        'email' => $checkoutData['email'],
        'password' => Hash::make($checkoutData['password']),
       ]);
      }
      Auth::login($user);
     }

     // Create shop
     $shop = Shop::create([
      'owner_id' => $user->id,
      'name' => $checkoutData['shop_name'],
      'phone' => $checkoutData['shop_phone'],
      'address' => $checkoutData['shop_address'],
      'is_active' => true,
     ]);

     // Get plan for email
     $plan = Plan::findOrFail($checkoutData['plan_id']);

     $sendConfirmationEmail = config('settings.send_confirmation_email', true);
     if ($sendConfirmationEmail && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
      \Mail::to($user->email)->send(new ShopOpenMail(
       $shop,
       $user,
       $plan,
       $checkoutData['duration_months'],
       $checkoutData['total_price']
      ));
     }

     $shopSettings = ShopSetting::create([
      'shop_id' => $shop->id,
      'currency_code' => 'EUR',
      'currency_symbol' => '€',
     ]);

     // Activate subscription
     $this->subscriptionService->activateSubscription(
      $shop,
      $plan,
      $checkoutData['duration_months']
     );

     // Get payer info
     $payerId = $result['payer']['payer_id'] ?? null;
     $paymentSource = array_key_first($result['payment_source'] ?? []);

     // Create payment record
     Payment::create([
      'user_id' => $user->id,
      'shop_id' => $shop->id,
      'plan_id' => $plan->id,
      'paypal_order_id' => $request->order_id,
      'paypal_payer_id' => $payerId,
      'amount' => $checkoutData['total_price'] * 100, // Convert to cents
      'currency' => 'EUR',
      'duration_months' => $checkoutData['duration_months'],
      'status' => 'completed',
      'payment_method' => $paymentSource === 'card' ? 'card' : 'paypal',
     ]);

     DB::commit();

     // Clear session data
     session()->forget('checkout_data');

     return response()->json([
      'success' => true,
      'redirect' => route('owner.dashboard'),
      'message' => 'Payment successful! Your subscription is now active.',
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

 /**
  * Handle cancelled payment
  */
 public function handleCancel()
 {
  session()->forget('checkout_data');

  return redirect()->route('welcome')->with('error', 'Payment was cancelled.');
 }
}
