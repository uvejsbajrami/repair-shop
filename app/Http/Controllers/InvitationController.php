<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class InvitationController extends Controller
{
    /**
     * Show the invitation acceptance form.
     */
    public function showAcceptForm(string $token)
    {
        $user = User::where('invitation_token', $token)
            ->whereNull('invitation_accepted_at')
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'This invitation link is invalid or has already been used.');
        }

        $shop = $user->employee?->shop;

        return view('auth.accept-invitation', compact('user', 'token', 'shop'));
    }

    /**
     * Accept the invitation and set password.
     */
    public function accept(Request $request, string $token)
    {
        $user = User::where('invitation_token', $token)
            ->whereNull('invitation_accepted_at')
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'This invitation link is invalid or has already been used.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
            'is_active' => true,
            'invitation_token' => null,
            'invitation_accepted_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('employee.dashboard')
            ->with('success', 'Welcome! Your account has been activated successfully.');
    }
}
