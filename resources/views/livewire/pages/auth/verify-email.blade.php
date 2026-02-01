<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Verify Email</h2>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 px-4 py-3 rounded-lg">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-3">
        <button wire:click="sendVerification"
            class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
            {{ __('Resend Verification Email') }}
        </button>

        <button wire:click="logout" type="submit"
            class="w-full py-3 border-2 border-gray-300 text-gray-600 rounded-lg font-semibold hover:border-gray-400 hover:bg-gray-50 transition">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
