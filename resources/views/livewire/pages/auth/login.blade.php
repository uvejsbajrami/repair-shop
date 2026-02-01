<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate([
            'form.email' => ['required', 'string', 'email'],
            'form.password' => ['required', 'string'],
        ]);

        $this->form->authenticate();

        Session::regenerate();

        // Redirect based on user role
        $user = Auth::user();

        if ($user->role === 'employee') {
            // Check if employee account is active
            if (!$user->is_active) {
                Auth::logout();
                Session::invalidate();
                Session::regenerateToken();
                $this->addError('form.email', 'Your employee account has been deactivated. Please contact your shop owner.');
                return;
            }
            $this->redirectIntended(default: route('employee.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('owner.dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Welcome Back</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="form.email" id="email"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="email" name="email" required autofocus autocomplete="username"
                placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="form.password" id="password"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="password"
                name="password"
                required autocomplete="current-password"
                placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="flex items-center justify-between mt-6 text-sm">
            @if (Route::has('password.request'))
                <a class="text-blue-600 hover:text-blue-700 hover:underline" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
            <a class="text-blue-600 hover:text-blue-700 hover:underline" href="{{ route('register') }}" wire:navigate>
                {{ __('Create account') }}
            </a>
        </div>
    </form>
</div>
