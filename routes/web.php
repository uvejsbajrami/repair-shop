<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PlanApplicationController;
use App\Http\Controllers\RenewalApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RenewController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Owner\ShopSettingsController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employee\EmployeeRepairsController;
use App\Http\Controllers\InvitationController;
use App\Livewire\TrackRepair;
use App\Models\Plan;

Route::get('/', function () {
    $plans = Plan::orderBy('price_monthly', 'asc')->get();
    return view('welcome', compact('plans'));
})->name('welcome');

Route::get('/track-repair', TrackRepair::class)->name('track.repair');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/plan/apply/{plan}', [PlanApplicationController::class , 'showApply'])->name('plan.apply')->middleware('auth');
Route::post('/plan/apply', [PlanApplicationController::class, 'submitApplication'])->name('plan.apply.submit');
Route::get('/plan/apply-success', [PlanApplicationController::class, 'showSuccess'])->name('plan.apply.success');

// Payment proof upload routes (authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/plan/payment-proof/{application}', [PlanApplicationController::class, 'showPaymentProof'])->name('plan.payment-proof');
    Route::post('/plan/payment-proof/{application}', [PlanApplicationController::class, 'uploadPaymentProof'])->name('plan.payment-proof.upload');
    Route::get('/plan/payment-proof/{application}/success', [PlanApplicationController::class, 'showPaymentProofSuccess'])->name('plan.payment-proof.success');
});

// Admin route to view payment proof image
Route::get('/admin/payment-proof/{application}/image', [PlanApplicationController::class, 'viewPaymentProofImage'])->name('admin.payment-proof.image')->middleware('auth');


// Checkout routes (public)
Route::get('/checkout/{plan:slug}', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout/calculate-price', [CheckoutController::class, 'calculatePrice'])->name('checkout.calculate');
Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
Route::post('/checkout/capture-order', [CheckoutController::class, 'captureOrder'])->name('checkout.capture-order');
Route::get('/checkout/cancel', [CheckoutController::class, 'handleCancel'])->name('checkout.cancel');

// Renewal routes (authenticated)
Route::middleware(['auth'])->group(function () {
    // PayPal renewal
    Route::get('/renew', [RenewController::class, 'showRenew'])->name('renew');
    Route::post('/renew/calculate-price', [RenewController::class, 'calculatePrice'])->name('renew.calculate');
    Route::post('/renew/create-order', [RenewController::class, 'createRenewOrder'])->name('renew.create-order');
    Route::post('/renew/capture-order', [RenewController::class, 'captureRenewOrder'])->name('renew.capture-order');

    // Renewal via application (cash/bank transfer)
    Route::get('/renew/apply', [RenewalApplicationController::class, 'showRenewApply'])->name('renew.apply');
    Route::post('/renew/apply', [RenewalApplicationController::class, 'submitRenewalApplication'])->name('renew.apply.submit');
    Route::get('/renew/apply-success', [RenewalApplicationController::class, 'showSuccess'])->name('renew.apply.success');
});

Route::get('/dashboard', function () {
    return redirect()->route('owner.dashboard');
    })
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Owner routes - dashboard is accessible even with expired plan (to show renewal options)
Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->middleware(['auth'])->name('owner.dashboard');

// All owner routes that require an active plan
Route::middleware(['auth', 'check.plan'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/repairs', [RepairsController::class, 'ownerRepairs'])->name('repairs');
    Route::get('/repairs-logs', [RepairsController::class, 'repairsLogs'])->name('repairs.logs');
    Route::get('/export/all', [RepairsController::class, 'RepairsAll'])->name('repairs.all');
    Route::get('/export-repairs', [RepairsController::class, 'exportRepairs'])->name('repairs.export');

    // Employee management
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/{employee}/resend', [EmployeeController::class, 'resendInvitation'])->name('employees.resend');
    Route::patch('/employees/{employee}/toggle', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // Shop settings (Pro plan only)
    Route::get('/settings', [ShopSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [ShopSettingsController::class, 'update'])->name('settings.update');
});

// Invitation acceptance (public route)
Route::get('/invitation/accept/{token}', [InvitationController::class, 'showAcceptForm'])->name('invitation.accept');
Route::post('/invitation/accept/{token}', [InvitationController::class, 'accept'])->name('invitation.accept.submit');

// Employee routes
Route::middleware(['employee', 'check.plan'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/repairs', [EmployeeRepairsController::class, 'index'])->name('repairs');
});

require __DIR__.'/auth.php';
