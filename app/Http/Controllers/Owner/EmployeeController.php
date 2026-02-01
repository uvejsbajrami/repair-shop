<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Shop;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmployeeInvitation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'You need a shop to manage employees.');
        }

        $employees = Employee::with('user')
            ->where('shop_id', $shop->id)
            ->get();

        $plan = $shop->shopPlan?->plan;
        $maxEmployees = $plan?->max_employees ?? 0;
        $currentCount = $employees->count();

        return view('owner.employees.index', compact('employees', 'shop', 'maxEmployees', 'currentCount'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'You need a shop to create employees.');
        }

        $plan = $shop->shopPlan?->plan;
        $maxEmployees = $plan?->max_employees ?? 0;
        $currentCount = Employee::where('shop_id', $shop->id)->count();

        if ($currentCount >= $maxEmployees) {
            return redirect()->route('owner.employees.index')
                ->with('error', "You've reached the maximum number of employees ({$maxEmployees}) for your plan.");
        }

        return view('owner.employees.create', compact('shop', 'maxEmployees', 'currentCount'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'You need a shop to create employees.');
        }

        // Check plan limits
        $plan = $shop->shopPlan?->plan;
        $maxEmployees = $plan?->max_employees ?? 0;
        $currentCount = Employee::where('shop_id', $shop->id)->count();

        if ($currentCount >= $maxEmployees) {
            return redirect()->route('owner.employees.index')
                ->with('error', "You've reached the maximum number of employees ({$maxEmployees}) for your plan.");
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Create user with invitation token
        $token = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(32)), // Random password, will be reset
            'role' => 'employee',
            'is_active' => false,
            'invitation_token' => $token,
            'invitation_sent_at' => now(),
        ]);

        // Create employee record
        Employee::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        // Send invitation email
        Mail::to($user->email)->send(new EmployeeInvitation($user, $shop, $token));

        return redirect()->route('owner.employees.index')
            ->with('success', "Invitation sent to {$user->email}. They will receive an email to set up their account.");
    }

    /**
     * Resend invitation email.
     */
    public function resendInvitation(Employee $employee)
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop || $employee->shop_id !== $shop->id) {
            abort(403);
        }

        $user = $employee->user;

        if ($user->invitation_accepted_at) {
            return redirect()->route('owner.employees.index')
                ->with('error', 'This employee has already accepted their invitation.');
        }

        // Generate new token
        $token = Str::random(64);
        $user->update([
            'invitation_token' => $token,
            'invitation_sent_at' => now(),
        ]);

        // Send invitation email
        Mail::to($user->email)->send(new EmployeeInvitation($user, $shop, $token));

        return redirect()->route('owner.employees.index')
            ->with('success', "Invitation resent to {$user->email}.");
    }

    /**
     * Toggle employee active status.
     */
    public function toggleStatus(Employee $employee)
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop || $employee->shop_id !== $shop->id) {
            abort(403);
        }

        $user = $employee->user;
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('owner.employees.index')
            ->with('success', "Employee {$user->name} has been {$status}.");
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {
        $shop = Shop::where('owner_id', auth()->id())->first();

        if (!$shop || $employee->shop_id !== $shop->id) {
            abort(403);
        }

        $userName = $employee->user->name;

        // Delete the user and employee record
        $employee->user->delete();
        $employee->delete();

        return redirect()->route('owner.employees.index')
            ->with('success', "Employee {$userName} has been removed.");
    }
}
