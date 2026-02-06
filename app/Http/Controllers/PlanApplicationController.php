<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\PlanApplication;
use App\Mail\PlanApplicationSubmit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlanApplicationController extends Controller
{
 /**
  * Show the plan application form
  */
 public function showApply(Plan $plan)
 {
  $userApplications = PlanApplication::where('user_id', Auth::id())
   ->where('plan_id', $plan->id)
   ->whereIn('status', ['pending', 'approved'])
   ->exists();
  if ($userApplications) {
   return redirect()->route('plan.apply.success');
  }
  $durations = [
   1 => '1 Month',
   3 => '3 Months',
   6 => '6 Months',
   12 => '12 Months (Save 15%)',
  ];

  return view('checkout.apply', [
   'plan' => $plan,
   'durations' => $durations,
  ]);
 }

 /**
  * Submit a plan application
  */
 public function submitApplication(Request $request)
 {
  $request->validate([
   'plan_id' => 'required|exists:plans,id',
   'duration_months' => 'required|in:1,3,6,12',
   'shop_name' => 'required|string|max:255',
   'language_code' => 'required|string|in:en,sq',
   'currency_code' => 'required|string|in:EUR,MKD',
   'name' => 'required|string|max:255',
   'email' => 'required|email|max:255',
   'phone' => 'nullable|string|max:20',
   'message' => 'nullable|string|max:1000',
  ]);

  $plan = Plan::findOrFail($request->plan_id);
  $durationMonths = (int) $request->duration_months;

  // Create the application
  $application = PlanApplication::create([
   'user_id' => Auth::id(), // null if guest
   'plan_id' => $plan->id,
   'shop_name' => $request->shop_name,
   'applicant_name' => $request->name,
   'applicant_email' => $request->email,
   'applicant_phone' => $request->phone,
   'billing_cycle' => $durationMonths >= 12 ? 'yearly' : 'monthly',
   'duration_months' => $durationMonths,
   'language_code' => $request->language_code,
   'currency_code' => $request->currency_code,
   'message' => $request->message,
   'status' => 'pending',
   'payment_status' => 'awaiting_proof',
  ]);

  // Send confirmation email
  if (filter_var($application->applicant_email, FILTER_VALIDATE_EMAIL)) {
   \Mail::to($application->applicant_email)->send(new PlanApplicationSubmit($application, $plan));
  }

  return redirect()->route('plan.apply.success')
   ->with('application_id', $application->id);
 }

 /**
  * Show success page after application
  */
 public function showSuccess()
 {
  $application = null;
  if (session('application_id')) {
   $application = PlanApplication::with('plan')->find(session('application_id'));
  }

  return view('checkout.apply-success', [
   'application' => $application,
  ]);
 }

 /**
  * Show the payment proof upload page
  */
 public function showPaymentProof(PlanApplication $application)
 {
  // Ensure user owns this application
  if ($application->user_id !== Auth::id()) {
   abort(403);
  }

  // Only allow proof upload for pending applications
  if ($application->status !== 'pending') {
   return redirect()->route('owner.dashboard')
    ->with('error', 'This application is no longer pending.');
  }

  return view('checkout.payment-proof', [
   'application' => $application->load('plan'),
  ]);
 }

 /**
  * Upload payment proof
  */
 public function uploadPaymentProof(Request $request, PlanApplication $application)
 {
  // Ensure user owns this application
  if ($application->user_id !== Auth::id()) {
   abort(403);
  }

  $request->validate([
   'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
  ]);

  // Delete old proof if exists
  if ($application->payment_proof_path) {
   Storage::disk('local')->delete($application->payment_proof_path);
  }

  // Store new proof in private storage
  $path = $request->file('payment_proof')->store(
   'payment-proofs/' . $application->id,
   'local'
  );

  $application->update([
   'payment_proof_path' => $path,
   'payment_status' => 'proof_submitted',
   'payment_proof_uploaded_at' => now(),
  ]);

  return redirect()->route('plan.payment-proof.success', $application)
   ->with('success', 'Payment proof uploaded successfully!');
 }

 /**
  * Show success page after uploading proof
  */
 public function showPaymentProofSuccess(PlanApplication $application)
 {
  if ($application->user_id !== Auth::id()) {
   abort(403);
  }

  return view('checkout.payment-proof-success', [
   'application' => $application->load('plan'),
  ]);
 }

 /**
  * View payment proof image (for admin)
  */
 public function viewPaymentProofImage(PlanApplication $application)
 {
  if (!$application->payment_proof_path) {
   abort(404);
  }

  // Try multiple possible paths
  $possiblePaths = [
   storage_path('app/' . $application->payment_proof_path),
   storage_path('app/private/' . $application->payment_proof_path),
   storage_path($application->payment_proof_path),
  ];

  $path = null;
  foreach ($possiblePaths as $possiblePath) {
   if (file_exists($possiblePath)) {
    $path = $possiblePath;
    break;
   }
  }

  if (!$path) {
   abort(404, 'Image not found');
  }

  return response()->file($path);
 }
}
