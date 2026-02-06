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
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">{{ __('auth.verify_email') }}</h2>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('auth.verify_email_message') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 px-4 py-3 rounded-lg">
            {{ __('auth.verification_link_sent') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-3">
        <button wire:click="sendVerification"
            class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
            {{ __('auth.resend_verification') }}
        </button>

        <button wire:click="logout" type="submit"
            class="w-full py-3 border-2 border-gray-300 text-gray-600 rounded-lg font-semibold hover:border-gray-400 hover:bg-gray-50 transition">
            {{ __('auth.log_out') }}
        </button>
    </div>
</div>
